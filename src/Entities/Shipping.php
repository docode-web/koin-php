<?php

namespace Docode\Koin\Entities;

class Shipping extends BaseEntity
{
    protected $fillable = [
        "Address",
        "DeliveryDate",
        "Price"
    ];

    protected $attributes = [
        "Address",
        "DeliveryDate",
        "Price"
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
        $this->attributes["DeliveryDate"] = $date->format("yyyy-mm-dd H:i:s");
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