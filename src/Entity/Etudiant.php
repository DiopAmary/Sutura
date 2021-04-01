<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtudiantRepository::class)
 */
class Etudiant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $paysOrigine;

   

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreAnneeMaroc;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numTelephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $villeEtude;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Etablissement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Filiere;

    /**
     * @ORM\OneToMany(targetEntity=Pret::class, mappedBy="etudiant")
     */
    private $pret;

    /**
     * @ORM\OneToMany(targetEntity=DeclarRemboursement::class, mappedBy="etudiant")
     */
    private $DeclarRemboursements;

   

    /**
     * @ORM\OneToMany(targetEntity=Reclamation::class, mappedBy="etudiant")
     */
    private $reclamations;

    /**
     * @ORM\OneToMany(targetEntity=Cotisation::class, mappedBy="etudiant")
     */
    private $cotisations;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Adressemail;

    public function __construct()
    {
        $this->pret = new ArrayCollection();
        $this->DeclarRemboursements = new ArrayCollection();
        $this->reclamations = new ArrayCollection();
        $this->cotisations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getPaysOrigine(): ?string
    {
        return $this->paysOrigine;
    }

    public function setPaysOrigine(string $paysOrigine): self
    {
        $this->paysOrigine = $paysOrigine;

        return $this;
    }

   

    public function getNombreAnneeMaroc(): ?int
    {
        return $this->nombreAnneeMaroc;
    }

    public function setNombreAnneeMaroc(int $nombreAnneeMaroc): self
    {
        $this->nombreAnneeMaroc = $nombreAnneeMaroc;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNumTelephone(): ?string
    {
        return $this->numTelephone;
    }

    public function setNumTelephone(string $numTelephone): self
    {
        $this->numTelephone = $numTelephone;

        return $this;
    }

    public function getVilleEtude(): ?string
    {
        return $this->villeEtude;
    }

    public function setVilleEtude(string $villeEtude): self
    {
        $this->villeEtude = $villeEtude;

        return $this;
    }

    public function getEtablissement(): ?string
    {
        return $this->Etablissement;
    }

    public function setEtablissement(string $Etablissement): self
    {
        $this->Etablissement = $Etablissement;

        return $this;
    }

    public function getFiliere(): ?string
    {
        return $this->Filiere;
    }

    public function setFiliere(string $Filiere): self
    {
        $this->Filiere = $Filiere;

        return $this;
    }

    /**
     * @return Collection|Pret[]
     */
    public function getPret(): Collection
    {
        return $this->pret;
    }

    public function addPret(Pret $pret): self
    {
        if (!$this->pret->contains($pret)) {
            $this->pret[] = $pret;
            $pret->setEtudiant($this);
        }

        return $this;
    }

    public function removePret(Pret $pret): self
    {
        if ($this->pret->removeElement($pret)) {
            // set the owning side to null (unless already changed)
            if ($pret->getEtudiant() === $this) {
                $pret->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DeclarRemboursement[]
     */
    public function getDeclarRemboursements(): Collection
    {
        return $this->DeclarRemboursements;
    }

    public function addDeclarRemboursement(DeclarRemboursement $declarRemboursement): self
    {
        if (!$this->DeclarRemboursements->contains($declarRemboursement)) {
            $this->DeclarRemboursements[] = $declarRemboursement;
            $declarRemboursement->setEtudiant($this);
        }

        return $this;
    }

    public function removeDeclarRemboursement(DeclarRemboursement $declarRemboursement): self
    {
        if ($this->DeclarRemboursements->removeElement($declarRemboursement)) {
            // set the owning side to null (unless already changed)
            if ($declarRemboursement->getEtudiant() === $this) {
                $declarRemboursement->setEtudiant(null);
            }
        }

        return $this;
    }

   

    /**
     * @return Collection|Reclamation[]
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations[] = $reclamation;
            $reclamation->setEtudiant($this);
        }

        return $this;
    }

	public  function __toString()
                        	{
                        		return $this->id ." ".$this->nom." ".$this->prenom;
                        	}
	
	
	
    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->reclamations->removeElement($reclamation)) {
            // set the owning side to null (unless already changed)
            if ($reclamation->getEtudiant() === $this) {
                $reclamation->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cotisation[]
     */
    public function getCotisations(): Collection
    {
        return $this->cotisations;
    }

    public function addCotisation(Cotisation $cotisation): self
    {
        if (!$this->cotisations->contains($cotisation)) {
            $this->cotisations[] = $cotisation;
            $cotisation->setEtudiant($this);
        }

        return $this;
    }

    public function removeCotisation(Cotisation $cotisation): self
    {
        if ($this->cotisations->removeElement($cotisation)) {
            // set the owning side to null (unless already changed)
            if ($cotisation->getEtudiant() === $this) {
                $cotisation->setEtudiant(null);
            }
        }

        return $this;
    }

    public function getAdressemail(): ?User
    {
        return $this->Adressemail;
    }

    public function setAdressemail(User $Adressemail): self
    {
        $this->Adressemail = $Adressemail;

        return $this;
    }
	
	public function compare(int  $Adressemail)
    {
        if($this->getId() == $Adressemail)
                 return true ;
		
		return false;
    }
}
