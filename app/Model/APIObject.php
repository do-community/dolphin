<?php

namespace App\Model;

class APIObject
{
    /** @var array info obtained with API call */
    protected $values;

    /**
     * Object constructor.
     * @param array $values
     */
    function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * @param string $name Key
     * @param string $value Value
     */
    function __set($name, $value)
    {
        $this->values[$name] = $value;
    }

    /**
     * @param string $name
     * @return string|null
     */
    function __get($name)
    {
        return isset($this->values[$name]) ? $this->values[$name] : null;
    }
}