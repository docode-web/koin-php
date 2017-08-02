<?php

namespace Docode\Koin\Entities;

/**
 * Class Address
 * @package Docode\Koin\Entities
 * @property string City
 * @property string State
 * @property string Country
 * @property string District
 * @property string Street
 * @property string Number
 * @property string Complement
 * @property string ZipCode
 * @property string AddressType
 */
class Address extends BaseEntity
{
    protected $fillable = [
        "City",
        "State",
        "Country",
        "District",
        "Street",
        "Number",
        "Complement",
        "ZipCode",
        "AddressType"
    ];

    /**
     * @param string $City
     * @return Address
     */
    public function setCity($City)
    {
        $this->City = $City;
        return $this;
    }

    /**
     * @param string $State
     * @return Address
     */
    public function setState($State)
    {
        $this->State = $State;
        return $this;
    }

    /**
     * @param string $Country
     * @return Address
     */
    public function setCountry($Country)
    {
        $this->Country = $Country;
        return $this;
    }

    /**
     * @param string $District
     * @return Address
     */
    public function setDistrict($District)
    {
        $this->District = $District;
        return $this;
    }

    /**
     * @param string $Street
     * @return Address
     */
    public function setStreet($Street)
    {
        $this->Street = $Street;
        return $this;
    }

    /**
     * @param string $Number
     * @return Address
     */
    public function setNumber($Number)
    {
        $this->Number = $Number;
        return $this;
    }

    /**
     * @param string $Complement
     * @return Address
     */
    public function setComplement($Complement)
    {
        $this->Complement = $Complement;
        return $this;
    }

    /**
     * @param string $ZipCode
     * @return Address
     */
    public function setZipCode($ZipCode)
    {
        $this->ZipCode = $ZipCode;
        return $this;
    }

    /**
     * @param string $AddressType see AddressType Enum
     * @return Address
     */
    public function setAddressType($AddressType)
    {
        $this->AddressType = $AddressType;
        return $this;
    }
}