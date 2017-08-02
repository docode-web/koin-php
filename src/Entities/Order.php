<?php

namespace Docode\Koin\Entities;


class Order extends BaseEntity
{
    protected $fillable = [
        "FraudId",
        "Reference",
        "Currency",
        "Price",
        "Price",
        "DiscountValue",
        "IncreasePercent",
        "IncreaseValue",
        "PaymentType",

        "Buyer",
        "Shipping",
        "Items",
        "AdditionalParameters"
    ];

    public $attributes = [
        "Buyer"     => [],
        "Shipping"  => [],
        "Items"     => [],
        "AdditionalParameters" => []
    ];

    /**
     * @param Buyer $buyer
     * @return $this
     */
    public function setBuyer(Buyer $buyer)
    {
        $this->attributes["Buyer"] = $buyer;
        return $this;
    }

    /**
     * @param Item $item
     * @return $this
     */
    public function addItem(Item $item)
    {
        $this->attributes["Items"][] = $item->toArray();
        return $this;
    }

    /**
     * @param Shipping $shipping
     * @return $this
     */
    public function setShipping(Shipping $shipping)
    {
        $this->attributes["Shipping"] = $shipping;
        return $this;
    }

    /**
     * @param $total
     * @return $this
     */
    public function setTotal($total)
    {
        $this->attributes["Price"] = $total;
        return $this;
    }
}