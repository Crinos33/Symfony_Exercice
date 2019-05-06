<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TasklistRepository")
 */
class Tasklist
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
     * @ORM\OneToMany(targetEntity="App\Entity\Listitem", mappedBy="tasklist")
     */
    private $Listitems;

    public function __construct()
    {
        $this->Listitems = new ArrayCollection();
    }

    public function getId(): ?int
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
     * @return Collection|Listitem[]
     */
    public function getListitems(): Collection
    {
        return $this->Listitems;
    }

    public function addListitem(Listitem $listitem): self
    {
        if (!$this->Listitems->contains($listitem)) {
            $this->Listitems[] = $listitem;
            $listitem->setTasklist($this);
        }

        return $this;
    }

    public function removeListitem(Listitem $listitem): self
    {
        if ($this->Listitems->contains($listitem)) {
            $this->Listitems->removeElement($listitem);
            // set the owning side to null (unless already changed)
            if ($listitem->getTasklist() === $this) {
                $listitem->setTasklist(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getName();
    }
}
