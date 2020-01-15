<?php

namespace Supplycart\Xero\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use Supplycart\Xero\Exceptions\InvalidAttributesException;

abstract class Data implements Arrayable
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Data constructor.
     * @param array $payload
     * @throws \Throwable
     */
    public function __construct(array $payload)
    {
        $this->data = $payload;

        foreach ($payload as $key => $value) {
            $this->{Str::camel($key)} = $value;
        }

        $this->validate();
    }

    public function __set($name, $value)
    {
        if (method_exists($this, $name)) {
            $this->$name($value);
        } else {
            $this->$name = $value;
        }
    }

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        } elseif (property_exists($this, $name)) {
            return $this->{$name};
        }

        return null;
    }

    public function toArray()
    {
        return $this->data;
    }

    /**
     * @throws \Throwable
     */
    public function validate()
    {
        $validator = validator($this->data, $this->rules());

        throw_if($validator->fails(), new InvalidAttributesException($validator->errors()));
    }

    public function rules()
    {
        return [];
    }
}
