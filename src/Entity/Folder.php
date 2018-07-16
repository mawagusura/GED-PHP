<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FolderRepository")
 */
class Folder implements \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\File", mappedBy="folder")
     */
    private $files;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Folder", mappedBy="parent")
     */
    private $childrens;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Folder", inversedBy="childrens")
     */
    private $parent;

    /**
     * Folder constructor.
     */
    public function __construct()
    {
        $this->files = new ArrayCollection();
        $this->childrens = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|File[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(File $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setRelation($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->contains($file)) {
            $this->files->removeElement($file);
            // set the owning side to null (unless already changed)
            if ($file->getRelation() === $this) {
                $file->setRelation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Folder[]
     */
    public function getChildrens(): Collection
    {
        return $this->childrens;
    }

    public function addChildren(Folder $children): self
    {
        if (!$this->childrens->contains($children)) {
            $this->childrens[] = $children;
            $children->setParent($this);
        }

        return $this;
    }

    public function removeChildren(Folder $children): self
    {
        if ($this->childrens->contains($children)) {
            $this->childrens->removeElement($children);
            // set the owning side to null (unless already changed)
            if ($children->getParent() === $this) {
                $children->setParent(null);
            }
        }

        return $this;
    }


    public function getParent() : Folder
    {
        return $this->parent;
    }

    public function setParent(Folder $par){
        $this->parent=$par;
    }

    /**
     * @return array
     * Return an array with all the parents
     */
    public function getAllParents() : array
    {
        // Fetch the list of the parents
        $parents = array();
        $folder = $this;
        while($folder->getId() != 1) {
            $parents[] = $folder;
            $folder = $folder->getParent();
        }
        // Put them in the good order (by deepness)
        $parents = array_reverse($parents);

        return $parents;
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()  : string
    {
        return serialize([$this->id, $this->parent,$this->childrens,$this->files]);
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
        [$this->id, $this->parent,$this->childrens,$this->files] = unserialize($serialized, ['allowed_classes' => false]);
    }

}
