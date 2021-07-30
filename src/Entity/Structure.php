<?php

namespace App\Entity;

use App\Repository\StructureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=StructureRepository::class)
 */
class Structure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max="255")
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Length(min = 9, max = 9)
     */
    private $siren;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     * @Assert\Type("string")
     */
    private $tradeAndCompanyRegister;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Length(max="255")
     * @Assert\Type("float")
     * @Assert\PositiveOrZero()
     */
    private $registeredCapital;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max="255")
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $companyForm;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     * @Assert\Email()
     * @Assert\Type("string")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     * @Assert\Type("string")
     */
    private $telephone;

    /**
     * @ORM\ManyToMany(targetEntity=Address::class, inversedBy="structures")
     */
    private $addresses;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     * @Assert\Type("string")
     */
    private $telephone2;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="structure")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=LegalPerson::class, mappedBy="structure")
     */
    private $legalPerson;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity=NaturalPerson::class, inversedBy="mainStructure", cascade={"persist", "remove"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $mainRepresentative;

    /**
     * @ORM\OneToOne(targetEntity=NaturalPerson::class, inversedBy="secondStructure", cascade={"persist", "remove"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $secondRepresentative;

    /**
     * @ORM\OneToMany(targetEntity=NaturalPerson::class, mappedBy="structureMember")
     */
    private $naturalPerson;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\PositiveOrZero()
     * @Assert\Type("integer")
     */
    private $shareUnitValue;

    /**
     * @ORM\OneToMany(targetEntity=College::class, mappedBy="structure")
     */
    private $colleges;

    /**
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="structure")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Executive::class, mappedBy="structure")
     */
    private $executives;

    /**
     * @ORM\OneToMany(targetEntity=Associate::class, mappedBy="structure")
     */
    private $associates;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="structure")
     */
    private $documents;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->user = new ArrayCollection();
        $this->legalPerson = new ArrayCollection();
        $this->naturalPeople = new ArrayCollection();
        $this->naturalPerson = new ArrayCollection();
        $this->colleges = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->executives = new ArrayCollection();
        $this->associates = new ArrayCollection();
        $this->documents = new ArrayCollection();
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

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(?string $siren): self
    {
        $this->siren = str_replace(' ', '', $siren);
        return $this;
    }

    public function getTradeAndCompanyRegister(): ?string
    {
        return $this->tradeAndCompanyRegister;
    }

    public function setTradeAndCompanyRegister(?string $tradeAndCompanyRegister): self
    {
        $this->tradeAndCompanyRegister = $tradeAndCompanyRegister;

        return $this;
    }

    public function getRegisteredCapital(): ?float
    {
        return $this->registeredCapital;
    }

    public function setRegisteredCapital(?float $registeredCapital): self
    {
        $this->registeredCapital = $registeredCapital;

        return $this;
    }

    public function getCompanyForm(): ?string
    {
        return $this->companyForm;
    }

    public function setCompanyForm(string $companyForm): self
    {
        $this->companyForm = $companyForm;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection|Address[]
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        $this->addresses->removeElement($address);

        return $this;
    }

    public function getTelephone2(): ?string
    {
        return $this->telephone2;
    }

    public function setTelephone2(?string $telephone2): self
    {
        $this->telephone2 = $telephone2;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setStructure($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getStructure() === $this) {
                $user->setStructure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LegalPerson[]
     */
    public function getLegalPerson(): Collection
    {
        return $this->legalPerson;
    }

    public function addLegalPerson(LegalPerson $legalPerson): self
    {
        if (!$this->legalPerson->contains($legalPerson)) {
            $this->legalPerson[] = $legalPerson;
            $legalPerson->setStructure($this);
        }

        return $this;
    }

    public function removeLegalPerson(LegalPerson $legalPerson): self
    {
        if ($this->legalPerson->removeElement($legalPerson)) {
            // set the owning side to null (unless already changed)
            if ($legalPerson->getStructure() === $this) {
                $legalPerson->setStructure(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMainRepresentative(): ?NaturalPerson
    {
        return $this->mainRepresentative;
    }

    public function setMainRepresentative(?NaturalPerson $mainRepresentative): self
    {
        $this->mainRepresentative = $mainRepresentative;

        return $this;
    }

    public function getSecondRepresentative(): ?NaturalPerson
    {
        return $this->secondRepresentative;
    }

    public function setSecondRepresentative(?NaturalPerson $secondRepresentative): self
    {
        $this->secondRepresentative = $secondRepresentative;

        return $this;
    }

    /**
     * @return Collection|NaturalPerson[]
     */
    public function getNaturalPerson(): Collection
    {
        return $this->naturalPerson;
    }

    public function addNaturalPerson(NaturalPerson $naturalPerson): self
    {
        if (!$this->naturalPerson->contains($naturalPerson)) {
            $this->naturalPerson[] = $naturalPerson;
            $naturalPerson->setStructureMember($this);
        }

        return $this;
    }

    public function removeNaturalPerson(NaturalPerson $naturalPerson): self
    {
        if ($this->naturalPerson->removeElement($naturalPerson)) {
            // set the owning side to null (unless already changed)
            if ($naturalPerson->getStructureMember() === $this) {
                $naturalPerson->setStructureMember(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getShareUnitValue(): ?int
    {
        return $this->shareUnitValue;
    }

    public function setShareUnitValue(?int $shareUnitValue): self
    {
        $this->shareUnitValue = $shareUnitValue;

        return $this;
    }

    /**
     * @return Collection|College[]
     */
    public function getColleges(): Collection
    {
        return $this->colleges;
    }

    public function addCollege(College $college): self
    {
        if (!$this->colleges->contains($college)) {
            $this->colleges[] = $college;
            $college->setStructure($this);
        }

        return $this;
    }

    public function removeCollege(College $college): self
    {
        if ($this->colleges->removeElement($college)) {
            // set the owning side to null (unless already changed)
            if ($college->getStructure() === $this) {
                $college->setStructure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setStructure($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getStructure() === $this) {
                $category->setStructure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Executive[]
     */
    public function getExecutives(): Collection
    {
        return $this->executives;
    }

    public function addExecutive(Executive $executive): self
    {
        if (!$this->executives->contains($executive)) {
            $this->executives[] = $executive;
            $executive->setStructure($this);
        }

        return $this;
    }

    public function removeExecutive(Executive $executive): self
    {
        if ($this->executives->removeElement($executive)) {
            // set the owning side to null (unless already changed)
            if ($executive->getStructure() === $this) {
                $executive->setStructure(null);
            }
        }

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
            $associate->setStructure($this);
        }

        return $this;
    }

    public function removeAssociate(Associate $associate): self
    {
        if ($this->associates->removeElement($associate)) {
            // set the owning side to null (unless already changed)
            if ($associate->getStructure() === $this) {
                $associate->setStructure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setStructure($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getStructure() === $this) {
                $document->setStructure(null);
            }
        }

        return $this;
    }
}
