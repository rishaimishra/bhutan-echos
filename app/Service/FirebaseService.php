<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class FirebaseService
{
    protected $url = 'https://exp.host/--/api/v2/push/send';

    public function sendNotification(array $deviceTokens, string $title, string $body, array $data = [])
    {
        $responses = [];

        foreach ($deviceTokens as $token) {
            $payload = [
                'to' => $token,
                'title' => $title,
                'body' => $body,
                'data' => $data,
                'sound' => 'default',
                'priority' => 'high',
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip, deflate',
            ])->post($this->url, $payload);

            $responses[] = $response->json();
        }

        return $responses;
    }
}
