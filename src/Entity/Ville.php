<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\VilleRepository")
 */
class Ville
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $eu_circo;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $code_region;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom_region;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $chef_lieu_region;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $numero_departement;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom_departement;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $prefecture;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $numero_circonscription;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom_commune;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $codes_postaux;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $code_insee;

    /**
     * @ORM\Column(type="decimal", precision=65, scale=2, nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="decimal", precision=65, scale=2, nullable=true)
     */
    private $longitude;

    /**
     * @ORM\Column(type="decimal", precision=65, scale=2, nullable=true)
     */
    private $eloignement;

    /**
     * @ORM\OneToMany(targetEntity="Contact", mappedBy="ville")
     */
    private $contact;

    public function __construct()
    {
        $this->contact = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEuCirco(): ?string
    {
        return $this->eu_circo;
    }

    public function setEuCirco(string $eu_circo): self
    {
        $this->eu_circo = $eu_circo;

        return $this;
    }

    public function getCodeRegion(): ?string
    {
        return $this->code_region;
    }

    public function setCodeRegion(string $code_region): self
    {
        $this->code_region = $code_region;

        return $this;
    }


    public function getChefLieuRegion(): ?string
    {
        return $this->chef_lieu_region;
    }

    public function setChefLieuRegion(string $chef_lieu_region): self
    {
        $this->chef_lieu_region = $chef_lieu_region;

        return $this;
    }

    
    public function getNomDepartement(): ?string
    {
        return $this->nom_departement;
    }

    public function setNomDepartement(string $nom_departement): self
    {
        $this->nom_departement = $nom_departement;

        return $this;
    }

    public function getPrefecture(): ?string
    {
        return $this->prefecture;
    }

    public function setPrefecture(string $prefecture): self
    {
        $this->prefecture = $prefecture;

        return $this;
    }

    public function getNumeroCirconscription(): ?int
    {
        return $this->numero_circonscription;
    }

    public function setNumeroCirconscription(int $numero_circonscription): self
    {
        $this->numero_circonscription = $numero_circonscription;

        return $this;
    }

    public function getNomCommune(): ?string
    {
        return $this->nom_commune;
    }

    public function setNomCommune(string $nom_commune): self
    {
        $this->nom_commune = $nom_commune;

        return $this;
    }

    public function getCodesPostaux(): ?string
    {
        return $this->codes_postaux;
    }

    public function setCodesPostaux(string $codes_postaux): self
    {
        $this->codes_postaux = $codes_postaux;

        return $this;
    }

    public function getCodeInsee(): ?string
    {
        return $this->code_insee;
    }

    public function setCodeInsee(string $code_insee): self
    {
        $this->code_insee = $code_insee;

        return $this;
    }

    public function getNomRegion(): ?string
    {
        return $this->nom_region;
    }

    public function setNomRegion(string $nom_region): self
    {
        $this->nom_region = $nom_region;

        return $this;
    }
    
    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getEloignement()
    {
        return $this->eloignement;
    }

    public function setEloignement($eloignement): self
    {
        $this->eloignement = $eloignement;

        return $this;
    }

    public function getNumeroDepartement(): ?string
    {
        return $this->numero_departement;
    }

    public function setNumeroDepartement(string $numero_departement): self
    {
        $this->numero_departement = $numero_departement;

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContact(): Collection
    {
        return $this->contact;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contact->contains($contact)) {
            $this->contact[] = $contact;
            $contact->setVille($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contact->contains($contact)) {
            $this->contact->removeElement($contact);
            // set the owning side to null (unless already changed)
            if ($contact->getVille() === $this) {
                $contact->setVille(null);
            }
        }

        return $this;
    }

}
