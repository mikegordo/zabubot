<?php

namespace Zabubot;

class Schedule
{
    /**
     * Contains item scheduled for execution now
     *
     * @var mixed
     */
    protected $schedule;

    public function __construct($filename)
    {
        if (!file_exists($filename)) {
            throw new \Exception("Schedule not found");
        }

        $this->schedule = $this->getScheduleItem($filename);
    }

    /**
     * FORMAT:
     * ;2018-10-10 22:00:00
     * message
     * The actual message goes here
     *
     * ;2018-10-11 04:10:00
     * photo
     * filename://foo.jpg
     * photo caption optional
     */

    protected function getScheduleItem($filename)
    {
        $content = file($filename);
        $now = date(";Y-m-d H:i:00");
        $now[16] = '0'; // minutes rounded to 10 always
        $set = [];
        $flag = false;

        foreach ($content as $line) {
            $line = trim($line);
            if ($line == $now && !$flag) {
                $flag = true;
                continue;
            }

            if ($flag) {
                if (strlen($line) > 0 && $line[0] == ';') {
                    break;
                }
                if (empty($type) && in_array($line, [ScheduleItem::TYPE_PHOTO, ScheduleItem::TYPE_MESSAGE])) {
                    $type = $line;
                    continue;
                }
                $set[] = $line;
            }
        }

        $tmp = implode(PHP_EOL, $set);
        $tmp = trim($tmp);
        $set = explode(PHP_EOL, $tmp);

        if (empty($type) && count($set) > 1) {
            throw new \Exception("Unable to determine the type");
        }

        if (empty($type)) {
            return false;
        }

        if ($type == ScheduleItem::TYPE_PHOTO && (count($set) < 1 || count($set) > 2)) {
            throw new \Exception("Photo type has incorrect number of parameters");
        }

        return new ScheduleItem($type, $set);
    }

    public function getSchedule()
    {
        return $this->schedule;
    }
}
