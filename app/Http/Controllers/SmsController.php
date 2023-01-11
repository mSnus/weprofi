<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client as TwilioClient; 

class SmsController extends Controller
{
    //
    public function show(Request $request)
    {
        return view('admin.sms');
    }

    public function send(Request $request)
    {
        $users = User::where('id', $request->user_id)->get();
        $sids = [];
        $response = [];
        $template = $request->template;


        foreach ($users as $user) {

            // $sid    = "AC5d77953baebf224c614965473b7a15d7"; 
            // $token  = "53dbe914e386b8737100ed487bfdbf30"; 
            // $twilio = new TwilioClient($sid, $token);

            // $twilio->setLogLevel('debug');

            $body = $template;
            $body = preg_replace('~\#name\#~', $user->name, $body);
            $body = preg_replace('~\#id\#~', $user->id, $body);
            $body = preg_replace('~\#invite_token\#~', $user->invite_token, $body);

            // $message = $twilio->messages 
            //                   ->create("972".$user->phone, // to 
            //                            array(  
            //                                "messagingServiceSid" => "MG558897411ed586deab230011aab79265",      
            //                                "body" => $body 
            //                            ) 
            //                   ); 
             
            // $sids[] = $message->sid;


            $sendSmsGateLink = 'http://webapi.mymarketing.co.il/api/smssendingrequest?'.
            'Token='.'0XF41E6695CE6FF93F8C4BEEB302A47E3BF538E03FBB237051FA9C6C479E81110B982BD66B6DC9A6223ECCD5E06804F208'.
            '&UnsubscribeText='.'Unsubscribe'.
            '&CanUnsubscribe='.'false'.
            '&Mobiles='."972".'534383059'.//$user->phone.
            '&Id='.'5449005'.
            '&Name='.'invite'.
            '&FromName='.'WeProfi'.
            '&SmsSendingProfileId='.'2627'.
            '&Content='.urlencode($body);
            

            $service_url = $sendSmsGateLink;
            $curl = curl_init($service_url);
            
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            $curl_response = curl_exec($curl);
            if ($curl_response === false) {
                $info = curl_getinfo($curl);
                curl_close($curl);
                // die('error occurred during curl exec. Additional info: ' . var_export($info));
                return view('admin.sms')->with('status', 'ОШИБКА:<br><pre>' . var_export($info,true) . '</pre>');
            }

            curl_close($curl);
            
            $decoded = json_decode($curl_response);
            
            if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
                // die('error occurred: ' . $decoded->response->errormessage);
                return view('admin.sms')->with('status', 'ОШИБКА:<br><pre>' . $decoded->response->errormessage . '</pre>');
            }

            // dd($decoded);
            $response[] = $decoded->id ?? $decoded->Message;
        }

        return view('admin.sms')->with('status', 'Отправлены сообщения:<br><pre>' . join('\n',$response) . '</pre>');
    }
}


 
