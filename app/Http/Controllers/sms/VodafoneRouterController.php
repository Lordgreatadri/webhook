<?php

namespace App\Http\Controllers\sms;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class VodafoneRouterController extends Controller
{
    //
    public function receiveCallBackResponse(Request $request)
    {
        // return $request;
        $headers = [
            "Content-Type: application/json",
            "Accept: application/json"    
        ];
        
        $bodyContent = $request->getContent();
        

        $response = Http::withHeaders($headers)->post(config("services.links.voda"), ['verify' => false], $bodyContent);
        // $statusCode = $response->status();
        // $responseBody = json_decode($response->getBody(), true);

        return $bodyContent;
        
        // return response()->json([
        //     'Status'=>301,
        //     'Success'=>true,
        //     'Message'=>'Your message'
        // ]);
    }
}
