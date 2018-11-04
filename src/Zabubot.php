<?php

namespace Zabubot;

class Zabubot
{
    protected $token;
    protected $channel;
    protected $url;

    public function __construct(Utils $utils)
    {
        $this->token = $utils->getToken();
        $this->channel = $utils->getChannel();
        $this->url = "https://api.telegram.org/bot" . $this->token;
    }

    public function run(Schedule $schedule)
    {
        $run = $schedule->getSchedule();

        if (empty($run)) {
            return;
        }

        switch ($run->type) {
            case ScheduleItem::TYPE_MESSAGE:
                $r = $this->sendMessage($run->message);
                break;
            case ScheduleItem::TYPE_PHOTO:
                $filename = __DIR__ . DIRECTORY_SEPARATOR . ".."  . DIRECTORY_SEPARATOR . trim($run->filename, DIRECTORY_SEPARATOR);
                $r = $this->sendPhoto($filename, $run->caption);
                break;
        }

        if (is_array($r)) {
            $r = json_encode($r);
        }

        echo "$r" . PHP_EOL;
    }

    protected function sendMessage($text)
    {
        $text = urlencode($text);

        $request = [
            "chat_id={$this->channel}",
            "text={$text}",
            "parse_mode=html",
            "disable_web_page_preview=true",
            "disable_notification=true",
        ];

        $response = file_get_contents($this->url . "/sendMessage?" . implode("&", $request));
        return $this->parseResponse($response);
    }

    protected function sendPhoto($filename, $caption)
    {
        $photo = new \CURLFile(realpath($filename));

        $request = [
            "photo" => $photo,
            "caption" => $caption,
            "disable_notification" => true
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, $this->url . "/sendPhoto?chat_id={$this->channel}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        $response = curl_exec($ch);

        return $this->parseResponse($response);
    }

    protected function parseResponse($response)
    {
        if (empty($response)) {
            return false;
        }

        $response = @json_decode($response, true);

        return [
            'ok' => $response['ok'],
            'message_id' => $response['result']['message_id'],
            'date' => date("Y-m-d H:i:s", $response['result']['date']),
        ];
    }
}
