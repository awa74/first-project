<?php
namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DemandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=DemandeRepository::class)
 */
class Demande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contenu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $examiner;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $valider;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $recuser;

    /**
     * @ORM\ManyToOne(targetEntity=Etudiant::class, inversedBy="demandes")
     */
    private $etudiant;

    /**
     * @ORM\ManyToOne(targetEntity=DERI::class, inversedBy="demandes")
     */
    private $dERI;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getExaminer(): ?string
    {
        return $this->examiner;
    }

    public function setExaminer(?string $examiner): self
    {
        $this->examiner = $examiner;

        return $this;
    }

    public function getValider(): ?string
    {
        return $this->valider;
    }

    public function setValider(?string $valider): self
    {
        $this->valider = $valider;

        return $this;
    }

    public function getRecuser(): ?string
    {
        return $this->recuser;
    }

    public function setRecuser(?string $recuser): self
    {
        $this->recuser = $recuser;

        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    public function getDERI(): ?DERI
    {
        return $this->dERI;
    }

    public function setDERI(?DERI $dERI): self
    {
        $this->dERI = $dERI;

        return $this;
    }
}
