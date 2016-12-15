# PHP client library for Payment Service API
- [Introduction](#introduction)
- [Installation](#installation)
- [How to use](#usage)
- [Available Resources](docs/)
    - [Bank](docs/Bank.md)
    - [Withdrawal](docs/Withdrawal.md)
- [References](#references)


<a name="introduction"></a>
## Introduction
This client package is developed to consume the payment service api, and this makes the process so easy. The basic idea behind the package is hiding the network access layer from the application layer. Developer no need to consider what is the endpoint and what is the HTTP method to access it, etc.,

As of [JSON API standards](http://jsonapi.org/format/#fetching-resources) `GET /banks/1 HTTP/1.1` will gives an individual resource object of type `bank`. Getting the resource and simply converted into an object of type `Bank` which will provide further functionality for the resource received from the API server.


<a name="installation"></a>
## Installation

```bash
composer require uluru/payment-service-php-client
```

<a name="configuration"></a>
## Configuration

### Include the library file
```php
include 'vendor/autoload.php';
```
<a name="authentication"></a>
## Client Authentication
```php
$token = "your-api-token";
$endpoint = "http://payment-service.dev/api";
\PaymentService\Client::config($token, $endpoint);
```
<a name="usage"></a>
## How to use
As I stated above setup is very simple as well as usage. First, let me show the standard traditional way in php using `cURL` to send/receive data to/from the server.
```php
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://your-api-endpoint",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{
    "data": {
      "type": "banks",
      "attributes": {
        "user_id": 1234,
        "bank_name" : "Test Bank",
        "bank_code" : "123",
        "branch_name" : "Test BRanch",
        "branch_code" : "456",
        "account_type" : 1,
        "account_no" : "7654321",
        "account_name" : "Account Holder",
        "bank_type" : 1
      }
    }
    }",
  CURLOPT_HTTPHEADER => array(
    "accept: application/json",
    "authorization: Bearer API_TOKEN",
    "cache-control: no-cache",
    "content-type: application/json",
  ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    // here your stuff to parse the required data from the response
    echo $response;
}
```
Next, using this php client library, we can simply configure the api credentials and then just play with the provided classes.
```php
Client::config('Your API Key', 'Base url of the API');
Bank::create([
    'user_id' => 1234,
    'bank_name' => '銀行名',
    'bank_code' => '銀行コード',
    'branch_name' => '支店名',
    'branch_code' => '支店コード',
    'account_type' => 1, //
    'account_no' => 7654321,
    'account_name' => 'アカウントメイ',
    'bank_type' => 1
]);
```
Done!

## References
  - [Laravel](http://www.laravel.com)
  - [Stripe](https://stripe.com/docs)