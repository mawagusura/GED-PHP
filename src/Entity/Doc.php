<?php
/**
 * Created by PhpStorm.
 * User: Lucas EFREI
 * Date: 10/07/2018
 * Time: 10:27
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\DocRepository")
 */
class Doc implements \Serializable
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $doc_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $doc_name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $doc_creation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $doc_description;

    /**
     * @ORM\Column(type="decimal", length=255)
     */
    private $doc_size;

    /**
     * @ORM\Column(type="datetime")
     */
    private $doc_last_mod;

    /**
     * @ORM\Column(type="blob")
     */
    private $doc_data;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $doc_tags;

    /**
     * @ORM\ManyToOne(targetEntity="DocType")
     * @ORM\JoinColumn(name="doc_type_id", referencedColumnName="type_id")
     */
    private $doc_doc_type;


    /**
     * @ORM\ManyToOne(targetEntity="Dossier")
     * @ORM\JoinColumn(name="dos_id", referencedColumnName="dos_id")
     */
    private $doc_dos;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    private $doc_user;

    /**
     * @return mixed
     */
    public function getDocName()
    {
        return $this->doc_name;
    }

    /**
     * @param mixed $doc_name
     */
    public function setDocName($doc_name): void
    {
        $this->doc_name = $doc_name;
    }

    /**
     * @return mixed
     */
    public function getDocCreation()
    {
        return $this->doc_creation;
    }

    /**
     * @param mixed $doc_creation
     */
    public function setDocCreation($doc_creation): void
    {
        $this->doc_creation = $doc_creation;
    }

    /**
     * @return mixed
     */
    public function getDocDescription()
    {
        return $this->doc_description;
    }

    /**
     * @param mixed $doc_description
     */
    public function setDocDescription($doc_description): void
    {
        $this->doc_description = $doc_description;
    }

    /**
     * @return mixed
     */
    public function getDocSize()
    {
        return $this->doc_size;
    }

    /**
     * @param mixed $doc_size
     */
    public function setDocSize($doc_size): void
    {
        $this->doc_size = $doc_size;
    }

    /**
     * @return mixed
     */
    public function getDocLastMod()
    {
        return $this->doc_last_mod;
    }

    /**
     * @param mixed $doc_last_mod
     */
    public function setDocLastMod($doc_last_mod): void
    {
        $this->doc_last_mod = $doc_last_mod;
    }

    /**
     * @return mixed
     */
    public function getDocData()
    {
        return $this->doc_data;
    }

    /**
     * @param mixed $doc_data
     */
    public function setDocData($doc_data): void
    {
        $this->doc_data = $doc_data;
    }

    /**
     * @return mixed
     */
    public function getDocTags()
    {
        return $this->doc_tags;
    }

    /**
     * @param mixed $doc_tags
     */
    public function setDocTags($doc_tags): void
    {
        $this->doc_tags = $doc_tags;
    }

    /**
     * @return mixed
     */
    public function getDocDocType() : DocType
    {
        return $this->doc_doc_type;
    }

    /**
     * @param mixed $doc_doc_type
     */
    public function setDocDocType(DocType $doc_doc_type): void
    {
        $this->doc_doc_type = $doc_doc_type;
    }

    /**
     * @return mixed
     */
    public function getDocDos() : Dossier
    {
        return $this->doc_dos;
    }

    /**
     * @param mixed $doc_dos
     */
    public function setDocDos(Dossier $doc_dos): void
    {
        $this->doc_dos = $doc_dos;
    }

    /**
     * @return mixed
     */
    public function getDocUser() : User
    {
        return $this->doc_user;
    }

    /**
     * @param mixed $doc_user
     */
    public function setDocUser(User $doc_user): void
    {
        $this->doc_user = $doc_user;
    }

    /**
     * @return mixed
     */
    public function getDocId()
    {
        return $this->doc_id;
    }



    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()  : string
    {
        return serialize([$this->doc_id, $this->doc_name, $this->doc_creation,$this->doc_description,$this->doc_size,
            $this->doc_last_mod,$this->doc_data,$this->doc_tags,$this->doc_user,$this->doc_doc_type,$this->doc_dos]);
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
        [$this->doc_id, $this->doc_name, $this->doc_creation,$this->doc_description,$this->doc_size,
            $this->doc_last_mod,$this->doc_data,$this->doc_tags,$this->doc_user,$this->doc_doc_type,$this->doc_dos] = unserialize($serialized, ['allowed_classes' => false]);
    }
}