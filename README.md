# Vtiger SDK (PHP)

A simple and clean SDK for interacting with a Vtiger API

## Connection
Connections to the API can be made using the following syntax

```php
$api = new VtigerApi();
$api->url('https://yoururlhere');
$token = $api->getToken($USERNAME, $SECRET);
```
