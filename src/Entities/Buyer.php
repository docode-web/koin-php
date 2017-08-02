<?php

namespace Docode\Koin\Entities;


class Buyer extends BaseEntity
{
    protected $fillable = [
        "Name",
        "Email",

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
}