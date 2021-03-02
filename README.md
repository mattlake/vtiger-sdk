# Vtiger Webservice SDK (PHP)

![](https://img.shields.io/github/last-commit/mattlake/vtiger-sdk?style=flat-square)
***

A simple and clean SDK for interacting with a Vtiger API.

This SDK does not include a Http client (Guzzle, Symfony HttpClient etc), it relies on one being provided that meets
PSR18 and uses PSR7 messages.

By reusing Psr18 compliant Http clients that are already in the code base removes the need for multiple dependecies
doing the same job and adding complexity.

***

## Connection

Connections to the API can be made using the following syntax

```php
$api = VtigerApi::endpoint($ENDPOINT, $PSR18_CLIENT)->login($USERNAME, $SECRET);
```

***

## Making a GET Request

Requests are build in a modular way, a request that got a list of modules available to the logged-in user would look
something like this:

```php
// Build the request
$request = \Trunk\VtigerSDK\Http\VtigerRequest::get()
    ->withParameter('sessionName', $api->getSessionName()) // Obtained through the login method
    ->withParameter('operation', 'listtypes') // operation being called
    ->return(\Trunk\VtigerSDK\Http\VtigerResponse::class); // Desired return type

// Execute the request
$response = $api->execute($request);
```

***

## Making a POST Request

POST requests are built using the same syntax as a GET request

```php
// Build the request
$request = VtigerRequest::post()
    ->withParameter('operation', 'login')
    ->withParameter('username', $username)
    ->withParameter('accessKey', $accessKey)
    ->return(VtigerResponse::class);

// Execute the request
$response = $this->execute($request);
```

***

## Return Types

### Vtiger Response

A Vtiger Response is the default return type for an API request.

It is a simple class structured as follows:

#### VtigerResponse

+ public success (bool)
+ public errorCode (string)
+ public errorMessage (string)
+ public returned value 1, eg recordId
+ public returned value 2, eg recordName
+ ...

### Vtiger Entity Model

#### VtigerEntityModel

+ private valueMap[] : An array of the data associated to the record
+ get(): Method to retrieve value from valueMap
+ set(): method to set values in the valueMap

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