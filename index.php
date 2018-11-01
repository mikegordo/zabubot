<?php

define("ROOT", __DIR__ . DIRECTORY_SEPARATOR);
include_once ROOT . "src" . DIRECTORY_SEPARATOR . "Zabubot.php";
include_once ROOT . "src" . DIRECTORY_SEPARATOR . "Utils.php";
include_once ROOT . "src" . DIRECTORY_SEPARATOR . "Schedule.php";
include_once ROOT . "src" . DIRECTORY_SEPARATOR . "ScheduleItem.php";

date_default_timezone_set("America/New_York");

$utils = new \Zabubot\Utils(ROOT . "config.ini");
$schedule = new \Zabubot\Schedule(ROOT . "schedule.html");

$z = new \Zabubot\Zabubot($utils);
$z->run($schedule);