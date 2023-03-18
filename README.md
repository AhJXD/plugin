# MadelineProto Plugin Base

**Async Plugin Based [MadelineProto](https://github.com/danog/MadelineProto) (user-)bot**

<br>

## Requirements
- MadelineProto [requirements](https://docs.madelineproto.xyz/docs/REQUIREMENTS.html)

<br>

## Installation

This package can be installed as a [Composer](https://getcomposer.org) dependency.

> Create a composer.json file.
```json
{
  "require": {
    "ahjxd/plugin": "*"
  },
  "minimum-stability": "beta"
}
```
> Then
```bash
composer update
```

## How To Start
> **Note** Just Extend Plugin\Handler & Do not forget define these methods :
```php
protected function getLoopDir() {
  return 'Plugin/Loop'; // Generic Loop Path
}

protected function getStartDir() {
  return 'Plugin/Start'; // onStart Path
}

protected function getPluginDir() {
  return 'Plugin/Plugin'; // Plugin Update Path
}
```

```php
<?php 
declare(strict_types=1);

include 'vendor/autoload.php';

use Revolt\EventLoop;
use \danog\MadelineProto\{
    Settings,
    Logger
};

class Plugin extends Plugin\Handler {
    const Admin = [ 1003575162 ];
    
    public function getReportPeers() {
        return self::Admin;
    }
    
    protected function getLoopDir() {
        return 'Plugin/Loop';
    }

    protected function getStartDir() {
        return 'Plugin/Start';
    }

    protected function getPluginDir() {
        return 'Plugin/Plugin';
    }

    public function onUpdateNewChannelMessage(array $update)
    {
        return $this->onUpdateNewMessage($update);
    }

    public function onUpdateNewMessage($update)
    {
        $mode      = '';
        $message   = $update['message']  ?? [];
        $text      = $message['message'] ?? '';
        $isOut     = $message['out']     ?? 0;
        $messageId = $message['id']      ?? 0;
        $fromId    = $message['from_id']['user_id']          ?? 0;
        $replyToId = $message['reply_to']['reply_to_msg_id'] ?? 0;
        $params    = compact(
            'update',
            'message',
            'text',
            'messageId',
            'fromId',
            'replyToId'
        );
        if (in_array($params['from_id'], self::Admin)) {
            $mode = 'Admin';
        }
        $type = ($this->plugin[$mode] ?? []) + ($this->plugin['public'] ?? []);
        array_map(fn($plugin) => EventLoop::queue($plugin, $params), $type);
    }
}

$settings = new Settings;
$settings->getPeer()
    ->setFullFetch(false)
    ->setFullInfoCacheTime(0)
    ->setCacheAllPeersOnStartup(false);
/*----------*/
$settings->getSerialization()
    ->setInterval(60);
/*----------*/
$settings->getLogger()
    ->setLevel(Logger::LEVEL_FATAL)
    ->setMaxSize(26214400);
/*----------*/
$settings->getAppInfo()
    ->setApiId()
    ->setApiHash('');   
/*----------*/
$settings->setDb((new Settings\Database\Memory)
	->setCleanup(true)
	->setEnableFullPeerDb(false)
	->setEnablePeerInfoDb(true)
);

Plugin::startAndLoop('Session', $settings);
```
