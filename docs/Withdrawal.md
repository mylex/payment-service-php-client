# Withdrawal
This class is responsible for all the requests regarding to Withdrawal.
## Methods
| Name        | Description  |
| ------------- | ------------- | ----- |
| [create](#create) | Creates new withdrawal resource |
| [get](#get) | Get a single withdrawal resource |
| [all](#all) | Fetches withdrawal records returns as Collection of withdrawal objects |
| [save](#save) | Save the current instance state |
| [delete](#delete) | Deletes the withdrawal record |
---
<a name="create"></a>
## create
### Description
Creates new withdrawal resource
### method syntax
```php
static Withdrawal create(array $params)
```
### Parameters
| Name        | Type           | Description  |
| ------------- | ------------- | ----- |
| bank_id | integer | **Required** Bank's unique identifier |
| amount | string | **Required** Amount to be transferred |
| pay_at | string | **Required** Processing date 'YYYY-MM-DD' |

### Return values
`create` method will return a newly created Withdrawal instance.

### Example

#### Input
```php
Withdrawal::create([
    'bank_id' => 1,
    'amount' => 2587,
    'pay_at' => '2016-12-20'
]);
```
#### Output
```php
Withdrawal {#166 ▼
  #fillable: array:3 [▶]
  #queryParams: array:3 [▶]
  #includeParams: array:1 [▶]
  #parentResourceName: "bank"
  #primaryKey: "id"
  #keyType: "int"
  #attributes: array:9 [▶]
  #original: array:9 [▼
    "id" => "1"
    "bank_id" => 1
    "amount" => 2587
    "status" => 0
    "error_code" => null
    "pay_at" => "2016-12-20"
    "sent" => null
    "created" => "2016-12-15 17:47:27"
    "modified" => "2016-12-15 17:47:27"
  ]
  -exists: true
  #relationships: []
  #hasHistory: false
}
```

<a name="get"></a>
## get
### Description
Get a single instance of Withdrawal resource.
### method syntax
```php
static Withdrawal get(integer $id[, array $options])
```
### Parameters
| Name        | Type           | Description  |
| ------------- | ------------- | ----- |
| id | integer | **Required** unique id of the desired Withdrawal object |

`get` method also accepts *optional* second parameter as an array, which has the following options
#### Optional
| Name        | Type           | Description  |
| ------------- | ------------- | ----- |
| user_id | integer | filter results by the `user_id` |
| include | string | includes the relationship object as an attribute to the object, the only available include is 'bank' |

### Return values
`get` method will return the corresponding `Withdrawal` object if the requested `id` is exists. Otherwise it will throw exception.
### Example

#### Input
```php
Withdrawal::get(2);
```
#### Output
`get` method will return the following result
```php
Withdrawal {#166 ▼
  #fillable: array:3 [▶]
  #queryParams: array:4 [▶]
  #includeParams: array:1 [▶]
  #parentResourceName: "bank"
  #primaryKey: "id"
  #keyType: "int"
  #attributes: array:9 [▶]
  #original: array:9 [▼
    "id" => "2"
    "bank_id" => 1
    "amount" => 1673
    "status" => 0
    "error_code" => null
    "pay_at" => "2016-12-20"
    "sent" => null
    "created" => "2016-12-15 18:34:28"
    "modified" => "2016-12-15 18:34:28"
  ]
  -exists: true
  #relationships: []
  #hasHistory: false
}
```
If you want to get the related resource `Bank` then you should do like this
```php
$withdrawal = Withdrawal::get(2, ['include' => 'bank']);
$bank = $withdrawal->bank();
```

<a name="all"></a>
## all
### Description
Retreive all the records of withrawals.
### method syntax
```php
static Withdrawal all([array $params])
```
### Parameters
The only *optional* parameter is an array can have the following options
#### Options
| Name        | Type           | Description  |
| ------------- | ------------- | ----- |
| status | integer | Status of the withdrawal<br>0 - Pending<br>1 - Processing <br>2 - Processed<br>3 - Success<br>4 - Failure<br>5 - Cancelled|
| user_id | integer | `user_id` related to Withdrawal |
| page | integer | specify the page number |

### Return values
The `all` method of `Withdrawal` class would return a collection of `Withdrawal` objects. You can verify the collection items by calling `count()` method.
### Example
```php
$withdrawals = Withdrawal::all(['status' => 1]);
```

<a name="save"></a>
## save
### Description
To update a resource, set the attributes which you want to update and trigger the `save()` method.
### method syntax
```php
public Withdrawal save()
```
### Parameters
It does not accept any parameters.
### Return value
Returns the updated instance if the `save()` successfully processed. Otherwise exception will be thrown.
### Example
```php
$withdrawal = Withdrawal::get(2);
$withdrawal->status = 4;
$withdrawal->save();
```
<a name="delete"></a>
## delete
### Description
To delete a resource, call `delete()` method of the `Withdrawal`'s object.
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
$bank = Withdrawal::get(2);
if ($bank->delete()) {
    return 'withdrawal deleted';
}
```
