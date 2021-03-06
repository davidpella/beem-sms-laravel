<?php

namespace DavidPella\BeemSms;

use ArrayAccess;
use DavidPella\BeemSms\Exceptions\CouldNotSendNotificationException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response;

class BeemSmsClient
{
    private string $apiKey;

    private string $secretKey;

    private string $baseUrl;

    protected string $message;

    protected string $recipient;

    public function __construct($apiKey, $secretKey)
    {
        $this->apiKey = $apiKey;
        $this->secretKey = $secretKey;
        $this->baseUrl = config('beem-sms.base_url');
    }

    /**
     * @throws CouldNotSendNotificationException|GuzzleException
     *
     * @return JsonResponse
     */
    public function dispatch(): JsonResponse
    {
        try {
            $client = new Client([
                'base_uri' => $this->baseUrl,
                'defaults' => [
                    'verify' => false,
                ],
            ]);

            $response = $client->request('POST', 'send', [
                'auth'    => [$this->apiKey, $this->secretKey],
                'headers' => [
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'source_addr'   => config('beem-sms.source_address'),
                    'encoding'      => 0,
                    'schedule_time' => '',
                    'message'       => $this->message,
                    'recipients'    => [
                        [
                            'recipient_id' => 1,
                            'dest_addr'    => $this->recipient,
                        ],
                    ],
                ],
            ]);

            if (!$response) {
                throw new CouldNotSendNotificationException('Service Unknown');
            }

            return $this->parseResponse($response);
        } catch (ClientException $exception) {
            return $this->parseException($exception);
        }
    }

    /**
     * @param array $payload
     *
     * @throws CouldNotSendNotificationException
     * @throws GuzzleException
     *
     * @return JsonResponse
     */
    public function send(array $payload): JsonResponse
    {
        $this->recipient($this->getRecipient($payload));

        $this->message($this->getMessage($payload));

        return $this->dispatch();
    }

    /**
     * @param $text
     *
     * @return $this
     */
    public function message($text): BeemSmsClient
    {
        $this->message = $text;

        return $this;
    }

    /**
     * @param $number
     *
     * @return $this
     */
    public function recipient($number): BeemSmsClient
    {
        $this->recipient = $number;

        return $this;
    }

    /**
     * @param array $payload
     *
     * @return array|ArrayAccess|mixed
     */
    protected function getRecipient(array $payload)
    {
        return Arr::get($payload, 'recipient', function () {
            throw new CouldNotSendNotificationException('Recipient is required');
        });
    }

    /**
     * @param array $payload
     *
     * @return array|ArrayAccess|mixed
     */
    protected function getMessage(array $payload)
    {
        return Arr::get($payload, 'message', function () {
            throw new CouldNotSendNotificationException('Message is required');
        });
    }

    /**
     * @param $response
     *
     * @return JsonResponse
     */
    protected function parseResponse($response): JsonResponse
    {
        return Response::json(['response' => json_decode(
            $response->getBody()->getContents()
        )]);
    }

    /**
     * @param ClientException $exception
     *
     * @return JsonResponse
     */
    protected function parseException(ClientException $exception): JsonResponse
    {
        return Response::json(['error' => json_decode(
            $exception->getResponse()->getBody()->getContents()
        )]);
    }
}
