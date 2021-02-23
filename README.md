# Vtiger SDK (PHP)

A simple and clean SDK for interacting with a Vtiger API

## Connection
Connections to the API can be made using the following syntax

```php
// verbose method
$api = VtigerApi::getInstance();
$api::url('https://yoururlhere');
$api->authenticate($username, $secret);

// Shorter version but same result
$api = VtigerApi::url('https://urlhere')->authenticate($username, $secret);
```
