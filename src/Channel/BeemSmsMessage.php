<?php

namespace DavidPella\BeemSms\Channel;

use BeemSms;
use DavidPella\BeemSms\BeemSmsClient;
use DavidPella\BeemSms\Exceptions\CouldNotSendNotificationException;
use GuzzleHttp\Exception\GuzzleException;

class BeemSmsMessage
{
    /**
     * @var string
     */
    protected string $recipient;

    /**
     * @var string
     */
    protected string $content;

    /**
     * @return mixed
     */
    public function send()
    {
        return BeemSms::sendMessage([
            "message" => $this->getContent(),
            "recipient" => $this->getRecipient(),
        ]);
    }

    /**
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param $recipient
     * @return $this
     */
    public function recipient($recipient): BeemSmsMessage
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * @param $content
     * @return $this
     */
    public function content($content): BeemSmsMessage
    {
        $this->content = $content;

        return $this;
    }
}
