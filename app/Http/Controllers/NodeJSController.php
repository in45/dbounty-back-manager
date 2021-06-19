<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NodeJSController extends Controller
{
    static function  get($endpoint,$data)
    {
        $api_token = "aa";
           try{
            $response = Http::withToken($api_token)->async()->get(env('URL_WEBSOCKET').$endpoint,$data);
            
            if($response->successful()) return $response;
            else $response->throw();
        } catch(\Exception $e){}
        
    }

    static function  post($endpoint,$data)
    {
        $api_token = "aa";
         try{
            $response = Http::withToken($api_token)->post(env('URL_WEBSOCKET').$endpoint,$data);
            
            if($response->successful()) return $response;
            else $response->throw();
        } catch(\Exception $e){}
    }
}
