# Vtiger SDK (PHP)

A simple and clean SDK for interacting with a Vtiger API

## Connection

Connections to the API can be made using the following syntax

```php
$api = VtigerApi::endpoint($ENDPOINT)->login($USERNAME, $SECRET);
```

### Get List Types

The below call will get a list of modules available to the logged in user.

```php
$api->getListTypes();
```

A successful call will have the following response in the form of an associative array:

```php
[
  'types' => ["Accounts", "Contacts"],
  'information' => [
        'Accounts' => [
           'isEntity' => true,
           'label' => "Organizations",
           'singular' => "Organization"
        ],
        'Contacts' => [
            'isEntity' => true,
            'label' => 'Contacts',
            'singular' => 'Contact'
       ]
  ]
]
```

### Describe Module

The below method returns an associative array containing details regarding a specified module.

```php
$api->describeModule('Accounts');
```

The response would be structured like below

```php
[
    'label' => "Accounts",
    'name' => "Accounts",
    'createable' => true,
    'updateable' => true,
    'deleteable' => true,
    'retrieveable' => true,
    'fields' => [
        [
            'name' => "accountname",
            'label' => "Organization Name",
            'mandatory' => true,
            'type' => [
                'name' => "string"
            ],
            'nullable' => false,
            'editable' => true,
            'default' => ""
        ],
        [
            'name' => "account_no",
            'label' => "Organization Number",
            'mandatory' => false,
            'type' => [
                'name' => "string"
            ],
            'nullable' => false,
            'editable' => false,
            'default' => ""
        ],
    'idPrefix' => "11",
    'isEntity' => true,
    'labelFields' => "accountname"
]
```

### Retrieve Vtiger Entity Record
To retrieve a record from Vtiger use the following call

```php
$account = $api->retrieve('Accounts',12345);
```

This will return a VtigerEntity object

## Testing
There is a full test suite built using [PestPHP](https://github.com/pestphp/pest)