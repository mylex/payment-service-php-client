<?php

namespace PaymentService\Base;

use Exception;
use ArrayAccess;
use LogicException;
use JsonSerializable;
use PaymentService\Client;
use PaymentService\Utils\Str;
use PaymentService\Api\Request;
use PaymentService\Contracts\Jsonable;
use PaymentService\Contracts\Arrayable;

abstract class Resource implements Arrayable, Jsonable, JsonSerializable
{
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $attributes = [];
    protected $original = [];
    protected $fillable = [];
    protected $queryParams = [];

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    public function listFill(array $list)
    {
        $newlist = [];
        foreach ($list as $key => $value) {
            $newlist[] = array_merge([
                    $this->getKeyName() => $this->getKey()
                ],
                $value['attributes']
            );
        }
        return static::hydrateRaw($newlist);
    }

    public function fill(array $attributes)
    {
        foreach ($this->fillableFromArray($attributes) as $key => $value) {
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            } elseif ($totallyGuarded) {
                throw new MassAssignmentException($key);
            }
        }
        return $this;
    }

    public function filterParams(array $params)
    {
        $filtered = [];
        foreach ($this->queryParamsFromArray($params) as $key => $value) {
            if ($this->isQueryable($key)) {
                $filtered[$key] = $value;
            }
        }
        return $filtered;
    }

    protected function fillableFromArray(array $attributes)
    {
        if (count($this->getFillable()) > 0) {
            return array_intersect_key($attributes, array_flip($this->getFillable()));
        }

        return $attributes;
    }

    protected function queryParamsFromArray(array $params)
    {
        if (count($this->getQueryParams()) > 0) {
            return array_intersect_key($params, array_flip($this->getQueryParams()));
        }
        return $params;
    }

    public function newInstance($attributes = [], $exists = false)
    {
        $resource = new static((array) $attributes);
        return $resource;
    }

    public static function create(array $attributes = [])
    {
        $resource = new static($attributes);
        return $resource->save([], 'post');
    }

    public static function all($params = [])
    {
        $params = is_array($params) ? $params : func_get_args();
        $instance = new static;
        $requestor =  $instance->requestor();
        $url = $instance->getCollectionUrl();
        $params = $instance->filterParams($params);
        $data =  $requestor->request('get', $url, $params, []);
        $data = $instance->listFill($data->json);
        return $data;
    }

    public static function get($id)
    {
        $instance = new static();
        $requestor =  $instance->requestor();
        $url = $instance->getInstanceUrl($id);
        $data =  $requestor->request('get', $url, [], []);
        $item = $data->json['attributes'];
        $item[$instance->getKeyName()] = $data->json[$instance->getKeyName()];
        return $instance->newFromApi($item);
    }

    public function getInstanceUrl($id, $parentId = null)
    {
        return $this->getCollectionUrl($parentId) . '/' . $id;
    }

    public function getCollectionUrl($parentId = null)
    {
        return '/' . self::className() . 's';
    }

    public static function hydrate(array $items, $connection = null)
    {
        $instance = new static;

        $items = array_map(function ($item) use ($instance) {
            return $instance->newFromApi($item);
        }, $items);

        return $instance->newCollection($items);
    }

    public function newFromApi($attributes = [], $connection = null)
    {
        $resource = $this->newInstance([], true);

        $resource->setRawAttributes((array) $attributes, true);

        return $resource;
    }

    public function newCollection(array $resources = [])
    {
        return new Collection($resources);
    }

    public static function hydrateRaw($items)
    {
        return static::hydrate($items, null);
    }

    public function requestor()
    {
        return new Request(Client::$token, Client::$endpoint);
    }

    public function delete()
    {
        if (is_null($this->getKeyName())) {
            throw new Exception('No primary key defined on model.');
        }

        $method='delete';
        $url = $this->getInstanceUrl($this->id);

        $requestor =  $this->requestor();

        $response =  $requestor->request($method, $url, [], []);
        if ($response->code == 204) {
            return true;
        }
        return false;
    }

    public function update(array $attributes = [], array $options = [])
    {
        if (! $this->exists) {
            return false;
        }
        return $this->fill($attributes)->save($options);
    }

    public function save(array $options = [])
    {
        if  ($this->id) {
            $method='patch';
            $url = $this->getInstanceUrl($this->id);
            $params = $this->wrapData($this->getAttributes(), true);
        } else {
            $method='post';
            $url = $this->getCollectionUrl();
            $params = $this->wrapData($this->getAttributes());
        }
        $requestor =  $this->requestor();
        $data =  $requestor->request($method, $url, $params, []);
        $item = $data->json['attributes'];
        $item[$this->getKeyName()] = $data->json[$this->getKeyName()];
        return $this->newFromApi($item);
    }

    public function wrapData($data, $update=false)
    {
        $base = self::className();
        if ($update) {
            $keyValue = $data[$this->getKeyName()];
            unset($data[$this->getKeyName()]);
            return [
                'data' => [
                    'type' => $base . 's',
                    $this->getKeyName() => $keyValue,
                    'attributes' => $data
                ]
            ];
        }
        return [
            'data' => [
                'type' => $base . 's',
                'attributes' => $data
            ]
        ];
    }

    public static function className()
    {
        $class = get_called_class();
        // Useful for namespaces: Foo\Charge
        if ($postfixNamespaces = strrchr($class, '\\')) {
            $class = substr($postfixNamespaces, 1);
        }
        $class = str_replace('_', '', $class);
        $name = urlencode($class);
        $name = strtolower($name);
        return $name;
    }

    public function getKey()
    {
        return $this->getAttribute($this->getKeyName());
    }

    public function getKeyName()
    {
        return $this->primaryKey;
    }

    public function setKeyName($key)
    {
        $this->primaryKey = $key;

        return $this;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }

    public function queryParams(array $queryParams)
    {
        $this->queryParams = $queryParams;
        return $this;
    }

    public function isQueryable($key)
    {
        if (in_array($key, $this->getQueryParams())) {
            return true;
        }
        return false;
    }

    public function getFillable()
    {
        return $this->fillable;
    }

    public function fillable(array $fillable)
    {
        $this->fillable = $fillable;

        return $this;
    }

    public function isFillable($key)
    {
        if (in_array($key, $this->getFillable())) {
            return true;
        }
        return empty($this->getFillable()) && ! Str::startsWith($key, '_');
    }

    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        return $this->attributes;
    }

    public function getAttribute($key)
    {
        if (! $key) {
            return;
        }
        if (array_key_exists($key, $this->attributes)) {
            return $this->getAttributeValue($key);
        }
    }

    public function getAttributeValue($key)
    {
        $value = $this->getAttributeFromArray($key);

        return $value;
    }

    protected function getAttributeFromArray($key)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }
    }
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    protected function asJson($value)
    {
        return json_encode($value);
    }

    public function fromJson($value, $asObject = false)
    {
        return json_decode($value, ! $asObject);
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setRawAttributes(array $attributes, $sync = false)
    {
        $this->attributes = $attributes;

        if ($sync) {
            $this->syncOriginal();
        }

        return $this;
    }

    public function getOriginal($key = null, $default = null)
    {
        return Arr::get($this->original, $key, $default);
    }

    public function syncOriginal()
    {
        $this->original = $this->attributes;

        return $this;
    }

    public function syncOriginalAttribute($attribute)
    {
        $this->original[$attribute] = $this->attributes[$attribute];

        return $this;
    }

    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    public function __isset($key)
    {
        return ! is_null($this->getAttribute($key));
    }

    public function __unset($key)
    {
        unset($this->attributes[$key], $this->relations[$key]);
    }

    public function __toString()
    {
        return $this->toJson();
    }

}