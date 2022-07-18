<?php

namespace App\Http\Controllers\ussd;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TigoUSSDCallBackController extends Controller
{
    public function receiveCallBackResponse(Request $request)
    {
        $headers = [
            "Content-Type: application/json",
            "Accept: application/json"    
        ];
        
        $bodyContent = $request->getContent();
    
        $response = Http::withHeaders($headers)->post(config("services.links.ussdtigo"), ['verify' => false], $bodyContent);
        // $statusCode = $response->status();
        // $responseBody = json_decode($response->getBody(), true);
    }
}
