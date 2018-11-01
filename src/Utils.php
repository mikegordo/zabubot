<?php

namespace Zabubot;

class Utils
{
    /**
     * Telegram token
     *
     * @var string
     */
    protected $token;

    /**
     * Telegram channel name
     *
     * @var string
     */
    protected $channel;

    /**
     * Utils constructor.
     * @param $filename
     * @throws \Exception
     */
    public function __construct($filename)
    {
        if (!file_exists($filename)) {
            throw new \Exception("Configuration not found");
        }

        $this->getConfiguration($filename);
    }

    protected function getConfiguration($filename)
    {
        $file = parse_ini_file($filename);
        $this->token = $file['TOKEN'];
        $this->channel = $file['CHANNEL'];

        if ($this->channel[0] != '@') {
            $this->channel = "@" . $this->channel;
        }
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return mixed
     */
    public function getChannel()
    {
        return $this->channel;
    }
}
