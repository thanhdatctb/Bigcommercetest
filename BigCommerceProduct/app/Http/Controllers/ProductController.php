<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public static function findImageById($id)
    {
        $client = new Client();
        $url = "https://api.bigcommerce.com/stores/he79zn89dm/v3/catalog/products/".$id."/images";
        $response = $client->get($url,["headers"=>[
            "X-Auth-Client"=>"f9eezfjqp0dc5adzhg3gfrfc7ow8rxu",
            "X-Auth-Token"=>"my7fguisvxnhhe8gzgprpqbmzmea9bk"
        ]]);
        $data = json_decode($response->getBody()->getContents());
        //echo("<pre>");
        //print_r($data);
        return $data->data;
    }
}
