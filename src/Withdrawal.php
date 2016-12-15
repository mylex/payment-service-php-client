<?php

namespace PaymentService;

use PaymentService\Base\Resource;

class Withdrawal extends Resource
{
    protected $fillable = [
        'bank_id',
        'amount',
        'pay_at',
    ];

    protected $queryParams = [
        'user_id',
        'status',
        'include',
        'page'
    ];

    protected $includeParams = [
        'bank'
    ];

    protected $parentResourceName = 'bank';
}
