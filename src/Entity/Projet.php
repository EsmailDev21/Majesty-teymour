<?php

namespace App\Entity;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategorieRepository;
/**
 * Projet
 *
 * @ORM\Table(name="projet")
 * @ORM\Entity
 */
class Projet
{
    /**
     * @var int
     *
     * @ORM\Column(name="idprojet", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idprojet;

    /**
     * @var string
     *
     * @ORM\Column(name="titreprojet", type="string", length=150, nullable=false)
     */
    private $titreprojet;

    /**
     * @var float
     *
     * @ORM\Column(name="prixprojet", type="float", precision=100, scale=0, nullable=false)
     */
    private $prixprojet;
 /**
  * * @var Categorie
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="projets")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="idcat")
     */
    private $category;
   

    public function getCategory_id()
    {
        return $this->category;
    }
   
    public function getIdprojet(): ?int
    {
        return $this->idprojet;
    }

    public function getTitreprojet(): ?string
    {
        return $this->titreprojet;
    }

    public function setTitreprojet(string $titreprojet): self
    {
        $this->titreprojet = $titreprojet;

        return $this;
    }

    public function getPrixprojet(): ?float
    {
        return $this->prixprojet;
    }

    public function setPrixprojet(float $prixprojet): self
    {
        $this->prixprojet = $prixprojet;

        return $this;
    }


}
