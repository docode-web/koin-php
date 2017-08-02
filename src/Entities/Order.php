<?php

namespace Docode\Koin\Entities;

/**
 * Class Order
 * @property string FraudId
 * @property string Reference
 * @property string Currency
 * @property float Price
 * @property float DiscountValue
 * @property float IncreasePercent
 * @property float IncreaseValue
 * @property string PaymentType
 * @property Buyer Buyer
 * @property Shipping Shipping
 * @property array Items
 * @property array AdditionalParameters
 * @package Docode\Koin\Entities
 */
class Order extends BaseEntity
{
    /**
     * @var array
     */
    protected $fillable = [
        "FraudId",
        "Reference",
        "Currency",
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
        "Currency"  => "BRL",
        "PaymentType"=> "21",
        "Buyer"     => [],
        "Shipping"  => [],
        "Items"     => []
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
     * @param string $FraudId
     * @return Order
     */
    public function setFraudId($FraudId)
    {
        $this->FraudId = $FraudId;
        return $this;
    }

    /**
     * @param string $Reference
     * @return Order
     */
    public function setReference($Reference)
    {
        $this->Reference = $Reference;
        return $this;
    }

    /**
     * @param string $Currency
     * @return Order
     */
    public function setCurrency($Currency)
    {
        $this->Currency = $Currency;
        return $this;
    }

    /**
     * @param float $Price
     * @return Order
     */
    public function setPrice($Price)
    {
        $this->Price = $Price;
        return $this;
    }

    /**
     * @param float $DiscountValue
     * @return Order
     */
    public function setDiscountValue($DiscountValue)
    {
        $this->DiscountValue = $DiscountValue;
        return $this;
    }

    /**
     * @param float $IncreasePercent
     * @return Order
     */
    public function setIncreasePercent($IncreasePercent)
    {
        $this->IncreasePercent = $IncreasePercent;
        return $this;
    }

    /**
     * @param float $IncreaseValue
     * @return Order
     */
    public function setIncreaseValue($IncreaseValue)
    {
        $this->IncreaseValue = $IncreaseValue;
        return $this;
    }

    /**
     * @param string $PaymentType
     * @return Order
     */
    public function setPaymentType($PaymentType)
    {
        $this->PaymentType = $PaymentType;
        return $this;
    }

    /**
     * @param array $AdditionalParameters
     * @return Order
     */
    public function addAdditionalParameters($AdditionalParameters)
    {
        $this->AdditionalParameters = $AdditionalParameters;
        return $this;
    }
}