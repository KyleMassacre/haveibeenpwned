# Laravel Have I been pwned

## Introduction

> A plugin to check if your users passwords have been pwned by a known data breach via https://haveibeenpwned.com

## Installation

Run:
```$xslt
composer require kylemass/haveibeenpwned:dev-master
```
Add the provider to your config file
```php
KyleMass\Hibp\Providers\HibpServiceProvider::class
```
Add the Facade
```php
'Hibp' => KyleMass\Hibp\Facades\Hibp::class
```
Next, publish the config file using:
```
php artisan vendor:publish --provider="KyleMass\Hibp\Providers\HibpServiceProvider" --tag=config
```
## To Use:
Inside your validation just add the:
`beenpwned` validation rule.:
```php
Validator::make($data, [
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:users|beenpwned:false',
    'password' => 'required|string|min:6|confirmed|beenpwned',
]);
```

**Please take note:** that there is a boolean parameter. By default this checks for passwords. 
By leaving the parameter off or setting it to `true` it will check the password against the
Have I been pwned API. If you set it to false, this will check their account login name or password.

Also note that by using the validation on an email and/or username, you potentially wont pass validation
for the registering user. Only use this if this is what you truly desire.

## TODO:
1. Make it framework agnostic
2. Add validating to a local storage of pwned accounts
