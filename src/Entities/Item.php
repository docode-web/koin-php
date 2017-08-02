<?php

namespace Docode\Koin\Entities;


/**
 * Class Item
 * @package Docode\Koin\Entities
 * @property string Reference
 * @property string Description
 * @property string Category
 * @property integer Quantity
 * @property float Price
 * @property array Attributes
 */
class Item extends BaseEntity
{
    public $fillable = [
        'Reference',
        'Description',
        'Category',
        'Quantity',
        'Price',
        'Attributes'
    ];

    public $attributes = [
        'Attributes' => []
    ];

    /**
     * @param string $Reference
     * @return Item
     */
    public function setReference($Reference)
    {
        $this->Reference = $Reference;
        return $this;
    }

    /**
     * @param string $Description
     * @return Item
     */
    public function setDescription($Description)
    {
        $this->Description = $Description;
        return $this;
    }

    /**
     * @param string $Category
     * @return Item
     */
    public function setCategory($Category)
    {
        $this->Category = $Category;
        return $this;
    }

    /**
     * @param int $Quantity
     * @return Item
     */
    public function setQuantity($Quantity)
    {
        $this->Quantity = $Quantity;
        return $this;
    }

    /**
     * @param float $Price
     * @return Item
     */
    public function setPrice($Price)
    {
        $this->Price = $Price;
        return $this;
    }

    /**
     * @param array $Attributes
     * @return Item
     */
    public function setAttributes($Attributes)
    {
        $this->Attributes = $Attributes;
        return $this;
    }
}