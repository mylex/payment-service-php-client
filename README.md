# PHP client library for Payment Service API
- [Introduction](#introduction)
  - [Installation](#installation)
  - [Configuration](#configuration)
- [Usage](#usage)
- [口座情報取得](#banks_all)
- [口座情報登録](#banks_create)
- [口座情報変更](#banks_update)
- [口座情報削除](#banks_delete)
- [口座情報更新履歴](#banks_history)
- [出金依頼](#withdrawals_create)
- [出金依頼ステータス変更](#withdrawals_update)
- [振込データ取得](#withdrawals_all)

<a name="introduction"></a>
## Introduction

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
### Configure the API credentials
```php
$token = "your-api-token";
$endpoint = "http://payment-service.dev/api";
\PaymentService\Client::config($token, $endpoint);
```

<a name="usage"></a>

<a name="banks_all"></a>
### 口座情報取得
全ての口座情報を取得出来ます。
```php
\PaymentService\Bank::all();
```
戻り値は以下通りです、複数のBankクラスを持ったCollectionオブジェクトになります。LaravelのCollectionクラスをカスタマイズして使っているのでいくつか便利なユティリティー関数をそのまま使えます。例えば`get`, `count`, `where`, `keys`, `pluck`など。。。
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
<a name="banks_create"></a>
### 口座情報登録

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
