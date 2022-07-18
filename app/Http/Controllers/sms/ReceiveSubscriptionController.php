<?php

namespace App\Http\Controllers\sms;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ReceiveSubscriptionController extends Controller
{
    //APP_ENV=production
    //APP_DEBUG=false
    //RateLimiter (30) routeserviceprovider 
    // APP_URL=to production url (http://webhook.mysmsinbox.com)

    //"DELETE /telnet_sdp/mt/v1/receive_sub/971?carrierId=1111971&accountIdType=MSISDN&accountId=233209326284&shortCode=1402 HTTP/1.1" 405 5158 "-" "Apache-HttpClient/4.5.13 (Java/1.8.0_302)"
    public function deletationStateChange(Request $request)
    {      
        try 
        {
            $servicesArray = array("971", "965", "962", "973", "966", "974", "976", "975", "961", "963", "970", "979", "988", "989", "982", "987", "980", "992", "978", "990");
            $serviceName = "";
            //request header
            $headers = [
                "Content-Type: application/json",
                "Accept: application/json"    
            ];
            $bodyContent = $request->getContent();
            //request body
            $postInput = [
                'action' => 'DELETION',
                'serviceName' => $this->getServiceName($request->serviceid),
                'carrierId' => $request->carrierId,
                'serviceid' => $request->serviceid,
                'accountIdType'=> $request->accountIdType,
                'accountId'=> $request->accountId,
                'shortCode'=> $request->shortCode,
                'body' => $bodyContent,
            ];
            
            // check if MT service in request else rout to SMS studio
            if(trim(in_array($request->serviceid, $servicesArray))){
                $response = Http::withHeaders($headers)->post(config("services.links.vodasub"), ['verify' => false], $postInput);
                \Log::info($postInput);
                // return $postInput;
            }
            else{
                // return "We are now doing sms studio routing";
                $response = Http::withHeaders($headers)->post(config("services.links.studio"), ['verify' => false], $postInput);
                \Log::info($postInput);
            }
            
            \Log::info($request);

            return response()->json([
                'Status'=>200,
                'Success'=>true,
                'Message'=>'Request received and processed successfully!'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
        
        // return $request->serviceid;
    }


    //"New subscription
    public function subscription(Request $request)
    {
        try 
        {
            // return $request->accountInfo['accountId'];
            // return $request->smsText;
            $servicesArray = array("971", "965", "962", "973", "966", "974", "976", "975", "961", "963", "970", "979", "988", "989", "982", "987", "980", "992", "978", "990");
            $serviceName = "";
            $headers = [
                "Content-Type: application/json",
                "Accept: application/json"    
            ];

            // check if MT service in request else rout to SMS studio 
            if(trim(in_array($request->serviceid, $servicesArray))) {
                $bodyContent = $request->getContent();
                $json = json_decode($bodyContent, true);
                $postInput = [
                    'action' => 'SUBSCRIPTION',
                    'serviceName' => $this->getServiceName($request->serviceid),
                    'serviceid' => $request->serviceid,
                    'body' => $json,
                ];
                \Log::info($postInput);
                // $response = Http::withHeaders($headers)->post(config("services.links.vodasub"), ['verify' => false], $postInput);
            }   
            else{
                // return "We are now doing sms studio routing";smsText
                $postInput = [
                    'action' => 'SUBSCRIPTION',
                    'serviceid' => $request->serviceid,
                    'text' => $request->smsText,
                    'msisdn' => $request->accountInfo['accountId'],
                    'shortCode' => $request->shortCode

                ];
                $response = Http::withHeaders($headers)->post(config("services.links.studio"), ['verify' => false], $postInput);
            }
            
            \Log::info($bodyContent);

            return response()->json([
                'Status'=>200,
                'Success'=>true,
                'Message'=>'Request received and processed successfully!'
            ]);
               
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }



    // update the subscription state................
    public function updateStateChange(Request $request)
    {
        try 
        {
            $servicesArray = array("971", "965", "962", "973", "966", "974", "976", "975", "961", "963", "970", "979", "988", "989", "982", "987", "980", "992", "978", "990");
            $serviceName = "";
            $bodyContent = $request->getContent();
            $json = json_decode($bodyContent, true);
            $headers = [
                "Content-Type: application/json",
                "Accept: application/json"    
            ];
            $postInput = [
                'action' => 'PUT',
                'serviceName' => $this->getServiceName($request->serviceid),
                'serviceid' => $request->serviceid,
                'body' => $json,
            ];
            // check if MT service in request else rout to SMS studio 
            if(trim(in_array($request->serviceid, $servicesArray))) {
                \Log::info($postInput);
                $response = Http::withHeaders($headers)->post(config("services.links.vodasub"), ['verify' => false], $postInput);
            }   
            else{
                // return "We are now doing sms studio routing";
                $response = Http::withHeaders($headers)->post(config("services.links.studio"), ['verify' => false], $postInput);
            }
            
            \Log::info($postInput);

            return response()->json([
                'Status'=>200,
                'Success'=>true,
                'Message'=>'Request received and processed successfully!'
            ]);
               
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }

    //other form of request methods
    public function stateChange(Request $request)
    {
        $servicesArray = array("971", "965", "962", "973", "966", "974", "976", "975", "961", "963", "970", "979", "988", "989", "982", "987", "980", "992", "978", "990");
        $serviceName = "";
        try 
        {
            // if(trim(in_array($request->serviceid, $servicesArray))) {
            //      \Log::info($request);
            // }
            // else{
            //     return "We are now doing sms studio routing";
            // }
            
            \Log::info($request);

            return response()->json([
                'Status'=>200,
                'Success'=>true,
                'Message'=>'Request received and processed successfully!'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
        
        // return $request->serviceid;
    }




    public function prefixPhoneNumberWithZero($msisdn)
    {
        // grab characters from index position 3
        $phoneNumber = \substr($msisdn, 1);

        // concat with 0
        $prefixPhoneNumberWithNoPlus = ''.$phoneNumber;

        return $prefixPhoneNumberWithNoPlus;
    }

    // getting service name from the given serviceid
    public function getServiceName($serviceid)
    {
        switch($serviceid) {
            case('971'):
                $serviceName = "GOSPEL";
                break;        
            case('965'):
                $serviceName = "WSDM";
                break;
            case('962'):
                $serviceName = "FIN";
                break;    
            case('973'):
                $serviceName = "MOVIES";
                break;
            case('966'):
                $serviceName = "CHEL";
                break;
            case('974'):
                $serviceName = "REALM";
                break; 
            case('976'):
                $serviceName = "MANU";
                break;  
            case('975'):
                $serviceName = "BARCA";
                break;   
            case('961'):
                $serviceName = "ARSNL";
                break; 
            case('963'):
                $serviceName = "LPOOL";
                break;  
            case('970'):
                $serviceName = "MANCITY";
                break; 
            case('979'):
                $serviceName = "CATHOLIC";
                break; 
            case('988'):
                $serviceName = "PPP";
                break; 
            case('989'):
                $serviceName = "PKN";
                break; 
            case('982'):
                $serviceName = "AG";
                break;
            case('987'):
                $serviceName = "FABU";
                break;
            case('980'):
                $serviceName = "GFA";
                break;  
            case('992'):
                $serviceName = "FAITHS";
                break;
            case('978'):
                $serviceName = "MONEY";
                break;
            case('990'):
                $serviceName = "CARE247";
                break;

            default:
                // $msg = 'Something went wrong.';
                $serviceName = "MCC USSD";
        }
        return $serviceName;
    }
















































    
    public function index()
    {
        // URL
        $apiURL = 'https://jsonplaceholder.typicode.com/posts';
        // POST Data

        $postInput = [

            'title' => 'Sample Post',

            'body' => "This is my sample curl post request with data",

            'userId' => 22

        ];
        // Headers
        $headers = [

            //...

        ];

        $response = Http::withHeaders($headers)->post($apiURL, ['verify' => false], $postInput);
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);
        echo $statusCode;  // status code
        dd($responseBody); // body response

    }


    public function guzzelhttp()
    {
        // URL
        $apiURL = 'https://jsonplaceholder.typicode.com/posts';
      	// POST Data
        $postInput = [
            'title' => 'Sample Post',
            'body' => "This is my sample curl post request with data",
            'userId' => 22
        ];
        // Headers
        $headers = [
            //...
        ];
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $apiURL, ['form_params' => $postInput, 'headers' => $headers]);    
        $responseBody = json_decode($response->getBody(), true);    
        echo $statusCode = $response->getStatusCode(); // status code
        dd($responseBody); // body response
    }


}
