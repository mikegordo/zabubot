<?php

namespace Zabubot;

class ScheduleItem
{
    const TYPE_MESSAGE = "message";
    const TYPE_PHOTO = "photo";

    public $type;
    public $message;
    public $caption;
    public $filename;

    public function __construct($type, $set)
    {
        if (empty($set)) {
            return;
        }

        $this->type = $type;

        switch ($type) {
            case static::TYPE_MESSAGE:
                $this->message = implode(PHP_EOL, $set);
                break;
            case static::TYPE_PHOTO:
                $this->filename = $set[0];
                $this->caption = $set[1] ?? "";
                break;
        }
    }
}
