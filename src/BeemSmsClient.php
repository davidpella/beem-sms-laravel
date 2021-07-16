<?php

namespace DavidPella\BeemSms;

use ArrayAccess;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Response;
use GuzzleHttp\Exception\GuzzleException;
use DavidPella\BeemSms\Exceptions\CouldNotSendNotificationException;

class BeemSmsClient
{
    protected Client $client;

    protected $message;

    protected $recipient;

    public function __construct()
    {
        $this->client = new Client([
            "base_uri" => config("beem-sms.base_uri"),
            "defaults" => [
                'verify' => false
            ]
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function send(): JsonResponse
    {
        try {
            $response = $this->client->request('POST', 'send', [
                "auth" => [
                    config("beem-sms.api_key"),
                    config("beem-sms.secret_key")
                ],
                "headers" => [
                    "Accept" => 'application/json',
                    "Content-Type" => "application/json",
                ],
                "json" => [
                    'source_addr' => config("beem-sms.source_address"),
                    'encoding' => 0,
                    'schedule_time' => '',
                    'message' => $this->message,
                    'recipients' => [
                        [
                            "recipient_id" => 1,
                            "dest_addr" => $this->recipient
                        ],
                    ]
                ],
            ]);

            return Response::json(["response" => json_decode(
                $response->getBody()->getContents()
            )]);
        } catch (ClientException $exception) {
            return Response::json(["error" => json_decode(
                $exception->getResponse()->getBody()->getContents()
            )]);
        } catch (GuzzleException $exception) {

        }
    }

    /**
     * @param array $payload
     * @return JsonResponse
     */
    public function sendMessage(array $payload): JsonResponse
    {
        $this->recipient($this->getRecipient($payload));

        $this->message($this->getMessage($payload));

        return $this->send();
    }

    /**
     * @param $text
     * @return $this
     */
    public function message($text): BeemSmsClient
    {
        $this->message = $text;

        return $this;
    }

    /**
     * @param $number
     * @return $this
     */
    public function recipient($number): BeemSmsClient
    {
        $this->recipient = $number;

        return $this;
    }

    /**
     * @param array $payload
     * @return array|ArrayAccess|mixed
     */
    protected function getRecipient(array $payload)
    {
        return Arr::get($payload, "recipient", function () {
            throw new CouldNotSendNotificationException("Recipient is required");
        });
    }

    /**
     * @param array $payload
     * @return array|ArrayAccess|mixed
     */
    protected function getMessage(array $payload)
    {
        return Arr::get($payload, "message", function () {
            throw new CouldNotSendNotificationException("Message is required");
        });
    }
}
