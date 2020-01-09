<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProductController extends BigcommerceController
{
    private $headers;
    public function __construct(Request $request)
    {
        
    }
    public function getHeaders($request)
    {
        $this->headers = [
        "X-Auth-Client"=> $request->session()->get("clientId"),
        "X-Auth-Token"=>  $request->session()->get("accessToken")
        ];
        return $this->headers;
    }
    public function findImageById($id,Request $request)
    {
        $client = new Client();
        $context =  $request->session()->get("context");
        $url = "https://api.bigcommerce.com/".$context."/v3/catalog/products/".$id."/images";
        $response = $client->get($url,["headers"=>$this->getHeaders($request)]);
        $data = json_decode($response->getBody()->getContents(),true);
        //echo("<pre>");
        //print_r($data);
        return $data["data"];
    }
    public function deleteById($id, Request $request)
    {
        $client = new Client();
        $context = $request->session()->get("context");
        $url = "https://api.bigcommerce.com/".$context."/v3/catalog/products/".$id;
        $respone = $client->delete($url,["headers"=>$this->getHeaders($request)]);

        return redirect("/");
    }
    public function prepareForUpdate($id, Request $request)
    {
        
        $product = $this->findById($id,$request);
        return view("editProduct",["product"=>$product]);
        
    }
    public function findById($id, Request $request)
    {
        $client = new Client();
        $context = $request->session()->get("context");
        $url = "https://api.bigcommerce.com/".$context."/v3/catalog/products/".$id;
        $respone = $client->get($url,["headers"=>$this->getHeaders($request)]);
        $data = json_decode($respone->getBody(),true);
        return $data["data"];
    }
    public function updateProduct($id,Request $request)
    {
        $context = $request->session()->get("context");
        $client = new Client();
        $url = "https://api.bigcommerce.com/".$context."/v3/catalog/products/".$id;
        $respone = $client->put($url, [
            "headers"=>$this->getHeaders($request),
            "json"=>[
                "name"=> $request->input("name"),
                "sku"=> $request->input("sku"),
                "description"=> $request->input("description")
            ]
        ]);
        return redirect("/");
    }
}
