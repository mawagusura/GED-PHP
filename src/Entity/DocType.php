<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\DocTypeRepository")
 */
class DocType implements \Serializable{

    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $type_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_name;


    /**
     * @return mixed
     */
    public function getTypeId() : int
    {
        return $this->type_id;
    }

    /**
     * @return String
     */
    public function getTypeName(): string
    {
        return $this->getTypeName();
    }

    public function setTypeName(string $typeName)
    {
        $this->type_name=$typeName;
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()  : string
    {
        return serialize([$this->type_id, $this->type_name]);
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized) : void
    {
        [$this->type_id, $this->type_name] = unserialize($serialized, ['allowed_classes' => false]);
    }
}