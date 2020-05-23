<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FamilyRepository")
 */
class Family
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="Detail", mappedBy="family", cascade={"persist","remove"})
     */
    private $detail;

    public function __construct()
    {
        $this->detail = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection|Detail[]
     */
    public function getDetail(): Collection
    {
        return $this->detail;
    }

    public function addDetail(Detail $detail): self
    {
        if (!$this->detail->contains($detail)) {
            $this->detail[] = $detail;
            $detail->setFamily($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): self
    {
        if ($this->detail->contains($detail)) {
            $this->detail->removeElement($detail);
            // set the owning side to null (unless already changed)
            if ($detail->getFamily() === $this) {
                $detail->setFamily(null);
            }
        }

        return $this;
    }
}
