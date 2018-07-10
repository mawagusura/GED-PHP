<?php
/**
 * Created by PhpStorm.
 * User: Lucas EFREI
 * Date: 10/07/2018
 * Time: 10:04
 */

namespace App\Entity;


class Dossier implements \Serializable
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $dos_id;

    /**
     * @return mixed
     */
    public function getDosId()
    {
        return $this->dos_id;
    }

    /**
     * @return mixed
     */
    public function getDosName()
    {
        return $this->dos_name;
    }

    /**
     * @param mixed $dos_name
     */
    public function setDosName($dos_name): void
    {
        $this->dos_name = $dos_name;
    }

    /**
     * @return mixed
     */
    public function getDosDosId()
    {
        return $this->dos_dos_id;
    }

    /**
     * @param mixed $dos_dos_id
     */
    public function setDosDosId($dos_dos_id): void
    {
        $this->dos_dos_id = $dos_dos_id;
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dos_name;

    /**
     * @ORM\Column(type="integer")
     */
    private $dos_dos_id;

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()  : string
    {
        return serialize([$this->dos_id, $this->dos_name, $this->dos_dos_id]);
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
        [$this->dos_id, $this->dos_name, $this->dos_dos_id] = unserialize($serialized, ['allowed_classes' => false]);
    }
}