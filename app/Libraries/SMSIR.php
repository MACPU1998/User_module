<?php

namespace App\Libraries;

use Exception;
use http\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SMSIR
{
    public function __construct(){

    }

    public static function send($mobile, $code)
    {
        try {
//            TODO get url and api key from config or env
            $curl = curl_init();
            // Check if initialization had gone wrong*
            if ($curl === false) {
                throw new Exception('failed to initialize');
            }

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.sms.ir/v1/send/verify",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_POSTFIELDS => json_encode([
                    'templateId' => "176891",
                    'mobile' => $mobile,
                    "parameters" => [
                          [
                            "name"=> "VCODE",
                            "value"=> (string) $code
                          ]
                      ],
                ]),
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => [
                    'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:105.0) Gecko/20100101 Firefox/105.0',
                    'Accept: */*',
                    'Accept-Language: en-US,en;q=0.5',
                    'Accept-Encoding: gzip, deflate, br',
                    'content-type: application/json',
                    'x-api-key: 1AhC4PGdfJu7KtK9upAhknX2S8DY2thKBgmNYUEWn5X6RUKxBw0tCxIsWNm4OFYe',
                    'Connection: keep-alive',
                    'Sec-Fetch-Dest: empty',
                    'Sec-Fetch-Mode: cors',
                    'Sec-Fetch-Site: same-origin',
                    'TE: trailers',
                ],
            ]);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            $response = curl_exec($curl);
            Log::error("sms1: ".$response);
            if ($response === false) {
                throw new Exception(curl_error($curl), curl_errno($curl));
            }
            curl_close($curl);
            // Check the return value of curl_exec(), too

            $response = json_decode($response, true);
            Log::error("sms2: ".$response);
            if (!isset($response['status']) || $response['status'] != 1) {
                throw new Exception($response['message'] ?? "SMS failed");
            }
        } catch (Exception $exception) {
            Log::error($exception);
        }
    }

    public static function send2($mobile, $code, $templateID = '66yatfnuc2whsww', $name = 0)
    {
        try {
//            TODO get url and api key from config or env https://api.sms.ir/v1/send/verify
            $variable = ['vcode' => (string) $code];
            $headers = [
                //...
                'apikey'=>"63cPu1sbFd8kY1JnQUAJqQucBg3THmNbx6uz_RxfJcs=",
            ];
            $response = Http::withoutVerifying()->withHeaders($headers)
                ->post('https://api2.ippanel.com/api/v1/sms/pattern/normal/send', [
                'code' => $templateID,
                'recipient' => $mobile,
                "sender" => "+983000505",
                'variable' => $variable,
            ] );
            $resBody = json_decode($response->getBody(), true);
            Log::error("sms response code : ".$response->status());
            if ($resBody && $resBody["code"] != 200 ) {
                throw new Exception($resBody['message']." ". $resBody["code"] ?? "SMS failed " . $resBody["code"]);
            }
            //$responseBody = json_decode($response->getBody(), true);

        } catch (Exception $exception) {
            Log::error($exception);
        }
    }

    public static function sendRegularSms($mobile,$templateID,$data)
    {
        try {
//            TODO get url and api key from config or env
            $curl = curl_init();
            // Check if initialization had gone wrong*
            if ($curl === false) {
                throw new Exception('failed to initialize');
            }

//            CURLOPT_POSTFIELDS => json_encode([
//                'code' => $templateID,
//                'recipient' => $mobile,
//                "sender" => "+983000505",
//                'variable' => $variable,
//            ]),

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.sms.ir/v1/send/verify",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_POSTFIELDS => json_encode([
                    'templateId' => $templateID,
                    'mobile' => $mobile,
                    "parameters" => $data,
                ]),
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => [
                    'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:105.0) Gecko/20100101 Firefox/105.0',
                    'Accept: */*',
                    'Accept-Language: en-US,en;q=0.5',
                    'Accept-Encoding: gzip, deflate, br',
                    'content-type: application/json',
                    'x-api-key: 1AhC4PGdfJu7KtK9upAhknX2S8DY2thKBgmNYUEWn5X6RUKxBw0tCxIsWNm4OFYe',
//                    'x-api-key: 3Hbfd0EZbPUK5lWB1jp4yoyPQwJEDeH9vJZJkFnURnKi5TrGFqg7uWN9C9V4eZKX',
                    'Connection: keep-alive',
                    'Sec-Fetch-Dest: empty',
                    'Sec-Fetch-Mode: cors',
                    'Sec-Fetch-Site: same-origin',
                    'TE: trailers',
                ],
            ]);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            $response = curl_exec($curl);
            Log::error("sms1: ".$response);
            if ($response === false) {
                throw new Exception(curl_error($curl), curl_errno($curl));
            }
            curl_close($curl);
            // Check the return value of curl_exec(), too

            $response = json_decode($response, true);
            Log::error("sms2: ".$response);
            if (!isset($response['status']) || $response['status'] != 1) {
                throw new Exception($response['message'] ?? "SMS failed");
            }
        } catch (Exception $exception) {
            Log::error($exception);
        }
    }
}
