<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity() @Table(name="user")
 **/
class User
{
    /**
     * @id @ORM\Column(type="integer") @GeneratedValue
     */
    protected $id;

    /** @ORM\Column(type="string") @GeneratedValue **/
    protected $name;

    /** @ORM\Column(type="string") @GeneratedValue **/
    protected $surname;

    /** @ORM\Column(type="string") @GeneratedValue **/
    protected $phone;

    /** @ORM\Column(type="string") @GeneratedValue **/
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