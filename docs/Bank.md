# Bank
This class is responsible for all the requests regarding to Bank.
## Methods
| Name        | Description  |
| ------------- | ------------- | ----- |
| [create](#create) | Creates new bank resource |
| [get](#get) | Get a single Bank resource |
| [all](#all) | Fetches bank records returns as Collection of Bank objects |
| [save](#save) | Save the current instance state |
| [delete](#delete) | Deletes the bank record associated with the instance |

<a name="create"></a>
## create
### Description
Creates new bank resource
### method syntax
```php
static Bank create(array $params)
```
### Parameters
| Name        | Type           | Description  |
| ------------- | ------------- | ----- |
| user_id | integer | **Required** User's unique identifier |
| bank_name | string | **Required** Name of the bank |
| bank_code | integer | **Required** Code for the bank |
| branch_name | string | **Required** Name of the branch |
| branch_code | integer | **Required** Code for the branch |
| account_type | integer | **Required** Type of the account|
| account_no | integer | Account number **Required** if `bank_type` is 1 |
| account_name | string | **Required** Name of the account holder |
| bank_type | integer | **Required** Type of the bank, 1 for Others, 2 for Japan Post Bank |
| japanpost_code_no | integer | Japan Post Bank Code number **Required** if `bank_type` is 2 |
| japanpost_account_no | integer | Japan Post Bank account number **Required** if `bank_type` is 2 |

### Return values
`create` method will return a newly created Bank instance.

### Example

#### Input
```php
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
#### Output
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


<a name="get"></a>
## get
### Description
Get a single instance of Bank resource.
### method syntax
```php
static Bank get(integer $id)
```
### Parameters
| Name        | Type           | Description  |
| ------------- | ------------- | ----- |
| id | integer | **Required** unique id of the desired Bank object |

### Return values
`get` method will return the corresponding `Bank` object if the requested `id` is exists. Otherwise it will throw exception.
### Example

#### Input
```php
Bank::get(2);
```
#### Output
`get` method will return the following result
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


<a name="all"></a>
## all
### Description
### method syntax
```php
static Bank all([array $params])
```
### Parameters
The only *optional* parameter is an array can have the following options
#### Options
| Name        | Type           | Description  |
| ------------- | ------------- | ----- |
| user_id | integer | `user_id` related to Bank |
| page | integer | specify the page number |

### Return values
The `all` method of `Bank` class would return a collection of `Bank` objects. You can verify the collection items by calling `count()` method.
### Example
#### Input
```php
Bank::all();
```
#### Output
```php
Collection {#186 ▼
  #items: array:6 [▼
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
<a name="save"></a>
## save
### Description
To update a resource, set the attributes which you want to update and trigger the `save()` method.
### method syntax
```php
public Bank save()
```
### Parameters
It does not accept any parameters.
### Return value
Returns the updated instance if the `save()` successfully processed. Otherwise exception will be thrown.
### Example
```php
$bank = Bank::get(2);
$bank->account_no = 7676767;
$bank->save();
```
<a name="delete"></a>
## delete
### Description
To delete a resource, call `delete()` method of the `Bank`'s object.
### method syntax
```php
public boolean delete()
```
### Parameters
It does not accept any parameters.
### Return value
Returns `true` if the resource is successfully deleted, otherwise `false`.
### Example
```php
$bank = Bank::get(2);
$bank->delete();
```
