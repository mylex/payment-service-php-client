<?php

namespace PaymentService;

use PaymentService\Base\Resource;

class Withdrawal extends Resource
{
    const WITHDRAWAL_STATUS_PENDING  = 0;
    const WITHDRAWAL_STATUS_PROCESSING  = 1; // new
    const WITHDRAWAL_STATUS_PROCESSED  = 2;
    const WITHDRAWAL_STATUS_SUCCESS = 3;
    const WITHDRAWAL_STATUS_FAILED = 4;
    const WITHDRAWAL_STATUS_CANCELLED = 5;

    protected $fillable = [
        'bank_id',
        'amount',
        'pay_at',
    ];

    protected $queryParams = [
        'bank_id',
        'include'
    ];

    protected $includeParams = [
        'bank'
    ];

    protected $parentResourceName = 'bank';

}
