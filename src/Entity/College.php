<?php

namespace App\Entity;

use App\Repository\CollegeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CollegeRepository::class)
 */
class College
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Assert\Type("float")
     * @Assert\NotBlank
     */
    private $nbVotingRight;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     * @Assert\NotBlank
     */
    private $prefixClassification;

    /**
     * @ORM\OneToMany(targetEntity=Associate::class, mappedBy="college")
     */
    private $associates;

    /**
     * @ORM\ManyToOne(targetEntity=Structure::class, inversedBy="colleges")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $structure;


    public function __construct()
    {
        $this->associates = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNbVotingRight(): ?float
    {
        return $this->nbVotingRight;
    }

    public function setNbVotingRight(float $nbVotingRight): self
    {
        $this->nbVotingRight = $nbVotingRight;

        return $this;
    }

    public function getPrefixClassification(): ?string
    {
        return $this->prefixClassification;
    }

    public function setPrefixClassification(string $prefixClassification): self
    {
        $this->prefixClassification = $prefixClassification;

        return $this;
    }

    /**
     * @return Collection|Associate[]
     */
    public function getAssociates(): Collection
    {
        return $this->associates;
    }

    public function addAssociate(Associate $associate): self
    {
        if (!$this->associates->contains($associate)) {
            $this->associates[] = $associate;
            $associate->setCollege($this);
        }

        return $this;
    }

    public function removeAssociate(Associate $associate): self
    {
        if ($this->associates->removeElement($associate)) {
            // set the owning side to null (unless already changed)
            if ($associate->getCollege() === $this) {
                $associate->setCollege(null);
            }
        }

        return $this;
    }

    public function getStructure(): ?Structure
    {
        return $this->structure;
    }

    public function setStructure(?Structure $structure): self
    {
        $this->structure = $structure;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
