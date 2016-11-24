# PHP client library for Payment Service API

## Installation

```bash
composer require uluru/payment-service-php-client
```

## Setup

### Include the library file
```php
include 'vendor/autoload.php';
```
### Configure the API credentials
```php
$token = "your-api-token";
$endpoint = "http://payment-service.dev/api";
\PaymentService\Client::config($token, $endpoint);
```

## Bank Resource

### Select All

```php
\PaymentService\Bank::all();
```
Result would be
```php
Collection {#186 ▼
  #items: array:15 [▼
    0 => Bank {#185 ▼
      #fillable: array:9 [▶]
      #queryParams: array:1 [▶]
      #primaryKey: "id"
      #keyType: "int"
      #attributes: array:15 [▶]
      #original: array:15 [▼
        "id" => "6"
        "client_id" => 1
        "user_id" => 66262
        "bank_code" => "123"
        "bank_name" => "I4r5JdGMe28XOFqL"
        "branch_name" => "YMlphVV1i8ZTvVmK"
        "branch_code" => "456"
        "account_type" => 1
        "account_no" => "4830157"
        "account_name" => "tn8HVbHF82WLx4aw"
        "bank_type" => 1
        "japanpost_code_no" => null
        "japanpost_account_no" => null
        "created" => "2016-11-17 13:49:41"
        "modified" => "2016-11-17 13:49:41"
      ]
    }
    1 => Bank {#184 ▶}
    2 => Bank {#183 ▶}
    3 => Bank {#174 ▶}
    4 => Bank {#173 ▶}
    5 => Bank {#172 ▶}
    6 => Bank {#170 ▶}
    7 => Bank {#171 ▶}
    8 => Bank {#168 ▶}
    9 => Bank {#169 ▶}
    10 => Bank {#178 ▶}
    11 => Bank {#177 ▶}
    12 => Bank {#176 ▶}
    13 => Bank {#175 ▶}
    14 => Bank {#191 ▶}
  ]
}
```

### Select single resource

```php
\PaymentService\Bank::get(2);
```

Result would be

```php
Bank {#169 ▼
  #fillable: array:9 [▶]
  #queryParams: array:1 [▼
    0 => "user_id"
  ]
  #primaryKey: "id"
  #keyType: "int"
  #attributes: array:15 [▶]
  #original: array:15 [▼
    "client_id" => 1
    "user_id" => 137144
    "bank_code" => "123"
    "bank_name" => "OuDYHq4U78gjRyjq"
    "branch_name" => "W9g1HRzLs13GPDoJ"
    "branch_code" => "456"
    "account_type" => 1
    "account_no" => "7130959"
    "account_name" => "m294WemSNcALS2je"
    "bank_type" => 1
    "japanpost_code_no" => null
    "japanpost_account_no" => null
    "created" => "2016-11-17 13:53:00"
    "modified" => "2016-11-17 13:53:00"
    "id" => "10"
  ]
}
```

### Create new resource

```php
\PaymentService\Bank::create([
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

Result would be

```php
Bank {#168 ▼
  #fillable: array:9 [▶]
  #queryParams: array:1 [▶]
  #primaryKey: "id"
  #keyType: "int"
  #attributes: array:15 [▶]
  #original: array:15 [▼
    "client_id" => 1
    "user_id" => 35180
    "bank_code" => "123"
    "bank_name" => "9zEbVD1hjcYabBVd"
    "branch_name" => "WEdhk3LenIYVIVox"
    "branch_code" => "456"
    "account_type" => 1
    "account_no" => 1804819
    "account_name" => "NCsfEVdRzh07fsq5"
    "bank_type" => 1
    "japanpost_code_no" => null
    "japanpost_account_no" => null
    "created" => "2016-11-17 19:59:59"
    "modified" => "2016-11-17 19:59:59"
    "id" => "24"
  ]
}
```
