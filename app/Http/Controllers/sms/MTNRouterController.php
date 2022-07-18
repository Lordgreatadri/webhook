<?php

namespace App\Http\Controllers\sms;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class MTNRouterController extends Controller
{
    public function receiveCallBackResponse(Request $request)
    {
        // return $request;
        // URL
        // $apiURL = config("services.links.mtn");
        
        $headers = [
            "Content-Type: application/json",
            "Accept: application/json"    
        ];
        $bodyContent = $request->getContent();
        // return $bodyContent;
        $response = Http::withHeaders($headers)->post(config("services.links.mtn"), ['verify' => false], $bodyContent);
        \Log::info($bodyContent);
        // $statusCode = $response->status();
        // $responseBody = json_decode($response->getBody(), true);
    }
}
