# Vtiger SDK (PHP)

A simple and clean SDK for interacting with a Vtiger API

## Connection
Connections to the API can be made using the following syntax

```php
$api = VtigerApi::getInstance($Psr18Client)
    ->url('https://yoururlhere')
    ->authenticate(config::USERNAME, config::SECRET);
```
