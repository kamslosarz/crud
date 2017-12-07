<?php
// src/Entity/User.php
namespace Entity;

/**
 * @Entity() @Table(name="user")
 **/
class User
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    private $id;

    /** @Column(type="string") **/
    private $name;

    /** @Column(type="string") **/
    private $surname;

    /** @Column(type="string") **/
    private $phone;

    /** @Column(type="string") **/
    private $address;

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