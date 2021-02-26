# Vtiger Webservice SDK (PHP)
![](https://img.shields.io/github/last-commit/mattlake/vtiger-sdk?style=flat-square)
***

A simple and clean SDK for interacting with a Vtiger API

***
## Connection


Connections to the API can be made using the following syntax

```php
$api = VtigerApi::endpoint($ENDPOINT)->login($USERNAME, $SECRET);
```

***
## Making a GET Request

Requests are build in a modular way, a request that got a list of modules available to the logged-in user would look something like this:
```php
// Create a request
$request = \Trunk\VtigerSDK\Http\VtigerRequest::get()
    ->withParameter('sessionName', $api->getSessionName()) // Obtained through the login method
    ->withParameter('operation', 'listtypes') // operation being called
    ->return(\Trunk\VtigerSDK\Http\VtigerResponse::class); // Desired return type

// Execute the request
$response = $api->execute($request);
```

***
## Provided Common Requests
### Get List Types
The below call will get a list of modules available to the logged-in user.

```php
$api->getListTypes();
```

A successful call will return a VtigerResponse object

***
### Describe Module

The below method returns an associative array containing details regarding a specified module.

```php
$api->describeModule('Accounts');
```

A successful call will return a VtigerResponse object


***
## Testing
There is a full test suite built using [PestPHP](https://github.com/pestphp/pest)