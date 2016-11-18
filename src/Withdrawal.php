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
        'bank_id'
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
}
