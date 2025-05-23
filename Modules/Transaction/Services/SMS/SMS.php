<?php

namespace Modules\Transaction\Services\SMS;

class SMS
{
    private function unifonic($to, $message)
    {
        $url = 'http://api.unifonic.com/rest/Messages/Send';
        $push_payload = array(
            "AppSid" => "H4Fxt1nbjZg7SLGxqDEgvCMjbJA6y",
            "Recipient" => '2' . $to,
            "Body" => $message
        );

        $rest = curl_init();
        curl_setopt($rest, CURLOPT_URL, $url);
        curl_setopt($rest, CURLOPT_POST, 1);
        curl_setopt($rest, CURLOPT_POSTFIELDS, $push_payload);
        curl_setopt($rest, CURLOPT_SSL_VERIFYPEER, false);  //disable ssl .. never do it online
        curl_setopt($rest, CURLOPT_HTTPHEADER,
            array(
                "Content-Type" => "application/x-www-form-urlencoded"
            ));
        curl_setopt($rest, CURLOPT_RETURNTRANSFER, 1); //by ibnfarouk to stop outputting result.
        $response = curl_exec($rest);
        return $response;
    }


    private function smsMisr($to, $message)
    {
        $to = is_array($to) ? $to : (array)$to;

        $addTwo = function ($number) {
            return '2' . $number;
        };

        $to = array_map($addTwo, $to);


        $url = 'https://smsmisr.com/api/webapi/?';
        $push_payload = array(
            "username" => "",
            "password" => "",//01000000
            "language" => "2",
            "sender" => "",
            "mobile" => json_encode($to),
            "message" => $message,
        );


        $rest = curl_init();
        curl_setopt($rest, CURLOPT_URL, $url . http_build_query($push_payload));
        curl_setopt($rest, CURLOPT_POST, 1);
        curl_setopt($rest, CURLOPT_POSTFIELDS, $push_payload);
        curl_setopt($rest, CURLOPT_SSL_VERIFYPEER, true);  //disable ssl .. never do it online
        curl_setopt($rest, CURLOPT_HTTPHEADER,
            array(
                "Content-Type" => "application/x-www-form-urlencoded"
            ));
        curl_setopt($rest, CURLOPT_RETURNTRANSFER, 1); //by ibnfarouk to stop outputting result.
        $response = curl_exec($rest);
        curl_close($rest);
        return $response;
    }


    private function smsbox($to, $message)
    {
        $url = 'https://smsbox.com/SMSGateway/Services/Messaging.asmx/Http_SendSMS?';
        $to = is_array($to) ? $to : (array)$to;

        $addTwo = function ($number) {
            return $number;
        };

        $to = array_map($addTwo, $to);

        $push_payload = array(
            "username" => env('SMSBOX_USERNAME'),
            "password" => env('SMSBOX_PASSWORD'),//01000000
            "customerid" => env('SMSBOX_CUSTOMER_ID'),
            "sendertext" => env('SMSBOX_SENDER_TEXT'),
            "recipientNumbers" => implode(',',$to),
            "messageBody" => $message,
            "defdate" => '',
            "isBlink" => false,
            "isFlash" => false,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url.http_build_query($push_payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = (array)simplexml_load_string($result);

        if($result['Result'] == 'false'){

            info($result);
            info('sms provider result false');
            return [
                'server_response' => 'error',
            ];
        }

        info($result);
        return $result;
    }

    public function send($to, $message, $provider = 'smsbox')
    {
        switch ($provider) {
            case'smsmisr':
                return $this->smsMisr($to, $message);
                break;
            case'unifonic':
                return $this->unifonic($to, $message);
                break;
            case'smsbox':
                return $this->smsbox($to, $message);
                break;
            default:
                return 'mismatch provider';
                break;
        }
    }
}
