<?php

namespace Docode\Koin\Entities;


use JsonSerializable;

class BaseEntity implements JsonSerializable
{
    protected $fillable = [];

    protected $attributes = [];

    public function __construct($data = [])
    {
        foreach($data as $key=>$value){
            if (in_array($key, $this->fillable)) {
                $this->attributes[$key] = $value;
            }
        }
    }

    /**
     * Transform to Json String
     * @return string
     */
    public function toJson()
    {
        return json_encode( (Object) $this->attributes );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return $this->attributes;
    }
}