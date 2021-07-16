<?php

namespace DavidPella\BeemSms\Channel;

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
        return app("DavidPella\BeemSms\BeemSmsClient")
            ->recipient($this->getRecipient())
            ->message($this->getContent())
            ->dispatch();
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
