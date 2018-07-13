<?php
/**
 * Created by PhpStorm.
 * User: Lucas EFREI
 * Date: 10/07/2018
 * Time: 10:04
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DossierRepository")
 */
class Dossier implements \Serializable
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $dos_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dos_name;


    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="Dossier", mappedBy="dos_parent")
     */
    private $dos_children;

    /**
     * @var Dossier
     * @ORM\ManyToOne(targetEntity="Dossier", inversedBy="dos_children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="dos_id")
     *
     */
    private $dos_parent;

    public function __construct(){
        $this->dos_children = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * @return int
     */
    public function getDosId() : int
    {
        return $this->dos_id;
    }

    /**
     * @return string
     */
    public function getDosName() : string
    {
        return $this->dos_name;
    }

    /**
     * @param string $dos_name
     */
    public function setDosName(string $dos_name): void
    {
        $this->dos_name = $dos_name;
    }

    /**
     * @return Dossier
     */
    public function getDosParent() : Dossier
    {
        return $this->dos_parent;
    }

    /**
     * @param mixed $dos_parent
     */
    public function setDosParent(Dossier $dos_parent): void
    {
        $this->dos_parent = $dos_parent;
    }


    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()  : string
    {
        return serialize([$this->dos_id, $this->dos_name, $this->dos_parent]);
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
        [$this->dos_id, $this->dos_name, $this->dos_parent] = unserialize($serialized, ['allowed_classes' => false]);
    }
}