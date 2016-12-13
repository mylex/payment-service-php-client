# PHP client library for Payment Service API
- [Introduction](#introduction)
  - [Installation](#installation)
  - [Configuration](#configuration)
    - [クライアント認証](#authentication)
- [Usage](#usage)
  [エラーハンドリング](#error_handling)
- [口座情報取得](#banks_all)
- [口座情報登録](#banks_create)

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
<a name="authentication"></a>
## クライアント認証
```php
$token = "your-api-token";
$endpoint = "http://payment-service.dev/api";
\PaymentService\Client::config($token, $endpoint);
```

<a name="usage"></a>
<a name="error_handling"></a>
## エラーハンドリング
このライブラリのほとんどすべての関数は、特定の種類の例外を発生する可能性があります。予期しない実行を回避するために、`try-catch`ブロック内にコードを書いたほうが良いでしょう！
```php
try {
    \PaymentService\Bank::all();
} catch (\Exception $ex) {
    var_dump($ex);
}
```

<a name="banks_all"></a>
## 口座情報取得
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
  ]
}
```
## インスタンス型リソースを取得
コレクションでレコードを取得する代わりに、APIから単一のリソースを取得することもできます。これにより、Bankクラスの`get`メソッドにIDを指定して呼び出します。 例えば,
```php
\PaymentService\Bank::get(2);
```
the above method will return the following result
```php
Bank {#169 ▼
  #fillable: array:9 [▶]
  #queryParams: array:2 [▶]
  #hasHistory: true
  #primaryKey: "id"
  #keyType: "int"
  #attributes: array:15 [▶]
  #original: array:15 [▼
    "id" => "61"
    "client_id" => 1
    "user_id" => 790917
    "bank_code" => 4466
    "bank_name" => "QhZ64e9gMiHvOiGf"
    "branch_name" => "EmcwfO7uofWzdm3j"
    "branch_code" => 763
    "account_type" => 1
    "account_no" => 1343936
    "account_name" => "RuhEpWvZzXHkVDCP"
    "bank_type" => 1
    "japanpost_code_no" => null
    "japanpost_account_no" => null
    "created" => "2016-12-13 16:00:13"
    "modified" => "2016-12-13 16:00:13"
  ]
  #includeParams: []
  -exists: true
  #parentResourceName: null
  #relationships: []
}
```
<a name="banks_create"></a>
## 口座情報登録
新しい銀行口座を登録するには、必要なパラメータを用意し、Bankクラスの`create`メソッドを呼び出します。
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
リクエストが成功した場合は、次の結果が得られます。 それ以外の場合は、対応する例外がAPIレスポンスに基づいて発生されます。
```php
Bank {#169 ▼
  #fillable: array:9 [▶]
  #queryParams: array:2 [▶]
  #hasHistory: true
  #primaryKey: "id"
  #keyType: "int"
  #attributes: array:15 [▶]
  #original: array:15 [▼
    "id" => "62"
    "client_id" => 1
    "user_id" => 1234
    "bank_code" => "銀行コード"
    "bank_name" => "銀行名"
    "branch_name" => "支店名"
    "branch_code" => "支店コード"
    "account_type" => 1
    "account_no" => 7654321
    "account_name" => "アカウントメイ"
    "bank_type" => 1
    "japanpost_code_no" => null
    "japanpost_account_no" => null
    "created" => "2016-12-13 16:03:15"
    "modified" => "2016-12-13 16:03:15"
  ]
  #includeParams: []
  -exists: true
  #parentResourceName: null
  #relationships: []
}
```
