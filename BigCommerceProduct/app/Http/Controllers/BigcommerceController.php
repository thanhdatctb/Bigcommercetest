<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BigcommerceController extends Controller
{
    //
    protected $baseUrl;
    public function __construct()
    {
        $this->baseUrl = env("APP_URL");
    }

    public function getClientId()
    {
        if(env("APP_ENV")=="local")
        {
            return env("BC_LOCAL_CLIENT_ID");
        }
        return env("BC_APP_CLIENT_ID");
    }

    public  function getClientSecret()
    {
        if(env("APP_ENV")=="local")
        {
            return env("BC_Local_Client_Secret");
        }
        return env("BC_App_Client_Secret");
    }
    public  function getAccessToken(Request $request)
    {
        if(env("APP_ENV")=="local")
        {
            return env("BC_LOCAL_ACCESS_TOKEN");
        }
        $context = $this->getContext($request);
        $access_token = DB::table("table_install_infor")->where("context","=",$context)->get("access_token")[0]->access_token;
        return $access_token;
    }
    public function install(Request $request)
    {
        $client = new Client();
        $respone = $client->request("post","https://login.bigcommerce.com/oauth2/token",[
            "json"=>[
                "client_id"=> $this->getClientId(),
                "client_secret"=> $this->getClientSecret(),
                "redirect_uri"=> $this->baseUrl."/auth/install",
                "grant_type"=> "authorization_code",
                "code"=> $request->input("code"),
                "scope"=> $request->input("scope"),
                "context"=>$request->input("context")
            ]
        ]);
        $data = json_decode($respone->getBody());
       DB::table("table_install_infor")->insert([
           "context"=> $data->context,
           "access_token"=>$data->access_token,
           "scope"=>$data->scope,
           "user_id"=>$data->user->id,
           "username"=>$data->user->username,
           "email"=>$data->user->email
       ]);
       if($respone->getStatusCode()==200)
       {
           //return redirect()->action("BigcommerceController@load");
           //echo("installed. Please reload page");
          $context = $this->getContext($request);
           $response = $client->get("https://api.bigcommerce.com/".$context."/v3/catalog/products",["headers"=>[
               "X-Auth-Client"=>$this->getClientId(),
               "X-Auth-Token"=>$data->access_token,
           ]]);
           $data = json_decode($response->getBody(),true);
           return(view("products",["products"=>$data["data"]]));
       }
       else
       {
           echo("install fail");
       }
    }
    private static function getData(Request $request)
    {
        $signalPayload = $request->input('signed_payload');
        list($encodeData,$encodeSignal)=explode(".",$signalPayload,2);
        //list($encodeData,$encodeSignal)=explode(".",$signalPayload,2);
        //$encodeData = explode(".",$signalPayload)[0];
        $data = json_decode(base64_decode($encodeData),true);
        return $data;
    }
    private function getContext(Request $request)
    {
        return BigcommerceController::getData($request)["context"];
    }
    public function load(Request $request)
    {
//        $signedPayload = $request->input('signed_payload');
//        list($encodeData,$encodeSignal)=explode(".",$signedPayload,2);
//        $data = json_decode(base64_decode($encodeData),true);
//        $context = $data["context"];
//        $access_token = DB::table("table_install_infor")->where("context","=",$context)->get("access_token")[0]->access_token;
        //print_r($access_token);
        $request->session()->put("clientId",$this->getClientId());
        $request->session()->put("accessToken",$this->getAccessToken($request));
        $request->session()->put("context",$this->getContext($request));
        return redirect("/");
    }
  public function uninstall(Request $request)
  {
    $context = $this->getContext($request);
    DB::table("table_install_infor")->where("context","=",$context)->delete();
  }
  public function index(Request $request)
  {
    $context = $request->session()->get("context");
    $client = new Client();
    $response = $client->get("https://api.bigcommerce.com/".$context."/v3/catalog/products",["headers"=>[
      "X-Auth-Client"=>$this->getClientId(),
      "X-Auth-Token"=>$request->session()->get("accessToken"),
      ]]);
    $data = json_decode($response->getBody(),true);
    $allImages = array();
    $productController = new ProductController($request);
    foreach ($data["data"] as $product)
    {
        //echo("<pre>");
        $images = ($productController->findImageById($product["id"],$request));
        $allImages[$product["id"]] = $images;
    }
    //print_r($allImages);
    return(view("products",[
        "products"=>$data["data"],
        "allImages"=>$allImages
    ]));
  }
}
