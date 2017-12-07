<?php

namespace Entity;

class User
{
    protected $id;

    protected $name;

    protected $surname;

    protected $phone;

    protected $address;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getAddress()
    {
        return $this->address;
    }
}

?>