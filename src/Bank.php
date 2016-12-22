<?php

namespace PaymentService;

use PaymentService\Base\Resource;

class Bank extends Resource
{
    protected $fillable = [
        'user_id',
        'bank_name',
        'bank_code',
        'branch_code',
        'branch_name',
        'account_type',
        'account_no',
        'account_name',
        'bank_type',
        'japanpost_code_no',
        'japanpost_account_no'
    ];

    protected $queryParams = [
        'user_id',
        'page'
    ];

    protected $hasHistory = true;
}
