<?php

namespace Docode\Koin\Entities;

/**
 * Class Shipping
 * @package Docode\Koin\Entities
 * @property string Address
 * @property \DateTime DeliveryDate
 * @property float Price
 */
class Shipping extends BaseEntity
{
    protected $fillable = [
        "Address",
        "DeliveryDate",
        "Price"
    ];

    protected $attributes = [
        "Address" => null,
        "DeliveryDate" => "",
        "Price" => 0
    ];

    /**
     * @param Address $address
     * @return $this
     */
    public function setAddress(Address $address)
    {
        $this->attributes["Address"] = $address;
        return $this;
    }

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setDeliveryDate(\DateTime $date)
    {
        $this->attributes["DeliveryDate"] = $date->format("Y-m-d H:i:s");
        return $this;
    }

    /**
     * @param $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->attributes["Price"] = $price;
        return $this;
    }
}