<?php

namespace DavidPella\BeemSms\Channel;

use DavidPella\BeemSms\BeemSmsClient;

class BeemSmsMessage
{
    public $recipient;

    public $content;

    public function send()
    {
        (new BeemSmsClient())
            ->message($this->getContent())
            ->recipient($this->getRecipient())
            ->send();
    }

    public function getRecipient()
    {
        return $this->recipient;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function recipient($recipient)
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function content($content)
    {
        $this->content = $content;

        return $this;
    }
}
