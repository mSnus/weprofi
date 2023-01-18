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

    public function realSendSms($smsText, $phone){
        $sendSmsGateLink = 'http://webapi.mymarketing.co.il/api/smssendingrequest?'.
        'Token='.'0XF41E6695CE6FF93F8C4BEEB302A47E3BF538E03FBB237051FA9C6C479E81110B982BD66B6DC9A6223ECCD5E06804F208'.
        '&UnsubscribeText='.'Unsubscribe'.
        '&CanUnsubscribe='.'false'.
        '&Mobiles='."972".'534384699'.//$phone.
        '&Id='.'5449005'.
        '&Name='.'invite'.
        '&FromName='.'WeProfi'.
        '&SmsSendingProfileId='.'2627'.
        '&Content='.urlencode($smsText);
        

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

        $response = $decoded->id ?? ($decoded->Message ?? dd($decoded, $curl_response, $sendSmsGateLink));

        return $response;
    }

    public function send(Request $request) {
        if (isset($request->send_mode) && ($request->send_mode == 'mass')) {
            return $this->massSend($request);
        } else {
            $user = User::where('id', $request->user_id)->first();
            $template = $request->template;

            $body = $template;
            $body = preg_replace('~\#name\#~', $user->name, $body);
            $body = preg_replace('~\#id\#~', $user->id, $body);
            $body = preg_replace('~\#invite_token\#~', $user->invite_token, $body);
            
            $response = $this->realSendSms($body, $user->phone);

            return $response;
        }
    }
    public function massSend(Request $request)
    {
        $users = User::where('id', $request->user_id)->get();
        $sids = [];
        $response = [];
        $template = $request->template;


        foreach ($users as $user) {
            if (substr($user->phone, 0, 1) == '4' || substr($user->phone, 0, 1) == '7'
            || $user->invite_token == '') {
                continue;
            }

            $body = $template;
            $body = preg_replace('~\#name\#~', $user->name, $body);
            $body = preg_replace('~\#id\#~', $user->id, $body);
            $body = preg_replace('~\#invite_token\#~', $user->invite_token, $body);

            $response[] = 'Было бы отправлено на ' . $user->phone;
            //$response[] = $this->realSendSms($body, $user->phone);
   
        }

        return view('admin.sms')->with('status', 'Отправлены сообщения:<br><pre>' . join('\n',$response) . '</pre>');
    }
}


 
