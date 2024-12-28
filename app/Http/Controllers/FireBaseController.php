<?php

namespace App\Http\Controllers;

use App\Models\Admin\SalePartner;
use App\Models\User;
use Google\Client as GoogleClient;
use App\Notifications\NotificationChannel;
use Illuminate\Http\Request;
use NotificationChannels\Fcm\FcmMessage;

class FireBaseController extends Controller
{
    public function updateDeviceToken(Request $request)
    {
        $request->validate([
            //'user_id' => 'required|exists:users,id',
            'fcm_token' => 'required|string',
        ]);
        $user = auth(getGuard())->user();
        $user->update(['fcm_token' => $request->fcm_token]);
        //$user->update(['fcm_token' => "6546546sadsas"]);

        return response()->json(['message' => 'Device token updated successfully']);
    }

    public function sendFcmNotification()
    {
//        $request->validate([
//            'user_id' => 'required|integer',
////            'title' => 'required|string',
////            'body' => 'required|string',
//        ]);

        $user = auth(getGuard())->user();

        //$user = auth()->user();
        $fcm = $user->fcm_token;

        if (!$fcm) {
            return response()->json(['message' => 'User does not have a device token'], 400);
        }

//        $title = $request->title;
//        $description = $request->body;
        $projectId = config('services.fcm.project_id'); # INSERT COPIED PROJECT ID

        $credentialsFilePath = __DIR__."/../../../config/firebase-auth.json";
        $client = new GoogleClient();
        $client->setAuthConfig($credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();

        $access_token = $token['access_token'];

        $headers = [
            "Authorization: Bearer $access_token",
            'Content-Type: application/json'
        ];

        $data = [
            "message" => [
                "token" => $fcm,
                "notification" => [
                    "title" => "شما یک پیام دارید",
                    "body" => "متن پیام تست",
                ],
            ]
        ];
        $payload = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return response()->json([
                'message' => 'Curl Error: ' . $err
            ], 500);
        } else {
            return response()->json([
                'message' => 'Notification has been sent',
                'response' => json_decode($response, true)
            ]);
        }
    }
}
