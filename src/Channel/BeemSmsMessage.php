<?php

namespace DavidPella\BeemSms\Channel;

use DavidPella\BeemSms\BeemSmsClient;

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

    public function send()
    {
        (new BeemSmsClient())
            ->message($this->getContent())
            ->recipient($this->getRecipient())
            ->send();
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
