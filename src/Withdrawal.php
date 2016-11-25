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

    public function getCollectionUrl($parentId = null)
    {
        if ($parentId) {
            return '/banks/' . $parentId . '/' . self::className() . 's';
        }
        return '/' . self::className() . 's';
    }

    public function save(array $options = [])
    {
        if  ($this->id) {
            $method='patch';
            $url = $this->getInstanceUrl($this->id, $this->bank_id);

        } else {
            $method='post';
            $url = $this->getCollectionUrl();
        }
        $requestor =  $this->requestor();
        $params = $this->wrapData($this->getAttributes());
        $data =  $requestor->request($method, $url, $params, []);
        $item = $data->json['attributes'];
        $item['id'] = $data->json['id'];
        return $this->newFromApi($item);
    }

    public function setIncludes($data)
    {
        if (!empty($this->includeParams)) {
            foreach ($this->includeParams as $include) {
                $className = "PaymentService\\" . Utils\Str::studly($include);
                $includeObject = new $className;
                $collection = $includeObject->listFill($data);
                $this->{$include} = $collection[0];
            }
        }
        return $this;
    }
}
