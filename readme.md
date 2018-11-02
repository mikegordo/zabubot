## zabubot
I created this little tool in about an hour to automate posting to my Telegram channel.
Setting this up is very straightforward. Zabubot doesn't have any dependecies.

1. Rename `config.ini-example` to `config.ini`

You probably know that already, but first you have to create an actual channel if you don't have it already. 
The name of that channel goes to `config.ini` file.

This tool also requires a telegram bot. Create one and insert its token in `config.ini` file.

It should look like this:
```
TOKEN=<your token>
CHANNEL=<channel name>
```

2. Rename `schedule.html-example` to `schedule.html`

And compose your schedule.
Yes, you will need `cron` to run it.
I was really lazy and didn't really want to invent the wheel here. So if you wanna post twice a day at 12pm and 4pm, your `crontab` should look like this:
```
0 12,16 * * * <path to this index.php file>
```

Same schedule must be in `schedule.html` file:
```
;2018-11-01 12:00:00
message
<b>The actual</b> message
that will be posted in your
channel.

You can use empty lines and some <tags> here.

;2018-11-01 16:00:00
message
Another message goes here.
```

Yeah, I know, this is too simple. But it works just fine for my needs.
If you have any suggestions I'll be happy to hear them.
