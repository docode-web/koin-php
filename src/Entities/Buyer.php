<?php

namespace Docode\Koin\Entities;

/**
 * Class Buyer
 * @package Docode\Koin\Entities
 * @property string Name
 * @property string Email
 * @property string Ip
 */
class Buyer extends BaseEntity
{
    protected $fillable = [
        "Name",
        "Email",
        "Ip",

        "Documents",
        "AdditionalInfo",
        "Phones",
        "Address"
    ];

    protected $attributes = [
        "Documents" => [],
        "AdditionalInfo" => [],
        "Phones" => [],
        "Address" => []
    ];

    /**
     * @param $cpf
     * @return $this
     */
    public function setCpf($cpf)
    {
        $this->attributes["Documents"][] = [
            "Key" => "CPF", "Value" => $cpf
        ];

        return $this;
    }

    public function getCpf()
    {
        foreach($this->attributes["Documents"] as $document){
            if ($document['Key'] == "CPF") {
                return $document['Value'];
            }
        }
        return null;
    }

    /**
     * @param $date string format yyyy-mm-dd
     * @return $this
     */
    public function setBirthday($date)
    {
        $this->attributes["AdditionalInfo"][] = [
            "Key" => "BirthDay", "Value" => $date
        ];

        return $this;
    }

    public function setAddress(Address $address)
    {
        $this->attributes["Address"] = $address;
        return $this;
    }

    /**
     * @param $ddd
     * @param $number
     * @param $type string see PhoneType
     * @return $this
     */
    public function addPhone($ddd, $number, $type)
    {
        $this->attributes["Phones"][] = [
            "AreaCode"  => $ddd,
            "Number"    => $number,
            "PhoneType" => $type
        ];

        return $this;
    }

    /**
     * @param string $Name
     * @return Buyer
     */
    public function setName($Name)
    {
        $this->Name = $Name;
        return $this;
    }

    /**
     * @param string $Email
     * @return Buyer
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;
        return $this;
    }

    /**
     * @param string $IpAddress
     * @return Buyer
     */
    public function setIp($IpAddress)
    {
        $this->Ip = $IpAddress;
        return $this;
    }
}