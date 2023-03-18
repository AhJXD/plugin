# MadelineProto Plugin Base

**Async Plugin Based [MadelineProto](https://github.com/danog/MadelineProto) (user-)bot**


## Requirements
- MadelineProto [requirements](https://docs.madelineproto.xyz/docs/REQUIREMENTS.html)


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
> **Note** Just Extend  [Plugin\Handler](example/index.php) & Do not forget define these [methods](example/index.php#L28-L38) :
```php
protected function getLoopDir() {
  return 'Loop'; // Generic Loop Path
}

protected function getStartDir(({
  return 'Start'; // onStart Path
}

protected function getPluginDir() {
  return 'Plugin'; // Plugin Update Path
}
```

## Example Plugin
> Check [Example folder](example/Plugs/Plugin)
> <br>
> You need to return a closure.


## Loop Plugin
> Check [Example folder](example/Plugs/Loop)
> <br>
> You need to return a closure that return an int as second.


## Start Plugin
> Check [Example folder](example/Plugs/Start)
> <br>
> You need to return a closure that return an int as second.

**Note**
> You don't need to `restart` the robot when you added (removed, etc...) a new plugin.\
> Just use `reload` command to refresh the plugins list.
