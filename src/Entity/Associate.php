<?php

namespace App\Entity;

use App\Repository\AssociateRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AssociateRepository::class)
 */
class Associate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Type("DateTimeInterface")
     */
    private $subscriptionDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Type("DateTimeInterface")
     */
    private $caApprovalDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Type("DateTimeInterface")
     */
    private $agApprovalDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Type("DateTimeInterface")
     */
    private $firstSubscribedCapitalPaymentsDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type("integer", message="La valeur {{ value }} n'est pas valide")
     * @Assert\PositiveOrZero()
     */
    private $numberOfShare;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type("integer", message="La valeur {{ value }} n'est pas valide")
     * @Assert\PositiveOrZero()
     */
    private $subscribedCapitalAmountPaidUp;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Type("DateTimeInterface")
     */
    private $withdrawalRequestDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Type("DateTimeInterface")
     */
    private $repaymentDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type("integer", message="La valeur {{ value }} n'est pas valide")
     * @Assert\PositiveOrZero()
     */
    private $repaymentAmount;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type("string")
     */
    private $expertiseField;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type("string")
     */
    private $referenceProjects;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="associates")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=College::class, inversedBy="associates")
     * @ORM\JoinColumn(nullable=true)
     */
    private $college;

    /**
     * @ORM\OneToOne(targetEntity=LegalPerson::class, inversedBy="associate", cascade={"persist", "remove"})
     */
    private $legalPerson;

    /**
     * @ORM\OneToOne(targetEntity=NaturalPerson::class, inversedBy="associate", cascade={"persist", "remove"})
     */
    private $naturalPerson;

    /**
     * @ORM\ManyToOne(targetEntity=Structure::class, inversedBy="associates")
     */
    private $structure;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubscriptionDate(): ?\DateTimeInterface
    {
        return $this->subscriptionDate;
    }

    public function setSubscriptionDate(?\DateTimeInterface $subscriptionDate): self
    {
        $this->subscriptionDate = $subscriptionDate;

        return $this;
    }

    public function getCaApprovalDate(): ?\DateTimeInterface
    {
        return $this->caApprovalDate;
    }

    public function setCaApprovalDate(?\DateTimeInterface $caApprovalDate): self
    {
        $this->caApprovalDate = $caApprovalDate;

        return $this;
    }

    public function getAgApprovalDate(): ?\DateTimeInterface
    {
        return $this->agApprovalDate;
    }

    public function setAgApprovalDate(?\DateTimeInterface $agApprovalDate): self
    {
        $this->agApprovalDate = $agApprovalDate;

        return $this;
    }

    public function getFirstSubscribedCapitalPaymentsDate(): ?\DateTimeInterface
    {
        return $this->firstSubscribedCapitalPaymentsDate;
    }

    public function setFirstSubscribedCapitalPaymentsDate(?\DateTimeInterface $firstSubscribedCapitalPaymentsDate): self
    {
        $this->firstSubscribedCapitalPaymentsDate = $firstSubscribedCapitalPaymentsDate;

        return $this;
    }

    public function getNumberOfShare(): ?int
    {
        return $this->numberOfShare;
    }

    public function setNumberOfShare(int $numberOfShare): self
    {
        $this->numberOfShare = $numberOfShare;

        return $this;
    }

    public function getSubscribedCapitalAmountPaidUp(): ?int
    {
        return $this->subscribedCapitalAmountPaidUp;
    }

    public function setSubscribedCapitalAmountPaidUp(?int $subscribedCapitalAmountPaidUp): self
    {
        $this->subscribedCapitalAmountPaidUp = $subscribedCapitalAmountPaidUp;

        return $this;
    }

    public function getWithdrawalRequestDate(): ?\DateTimeInterface
    {
        return $this->withdrawalRequestDate;
    }

    public function setWithdrawalRequestDate(?\DateTimeInterface $withdrawalRequestDate): self
    {
        $this->withdrawalRequestDate = $withdrawalRequestDate;

        return $this;
    }

    public function getRepaymentDate(): ?\DateTimeInterface
    {
        return $this->repaymentDate;
    }

    public function setRepaymentDate(?\DateTimeInterface $repaymentDate): self
    {
        $this->repaymentDate = $repaymentDate;

        return $this;
    }

    public function getRepaymentAmount(): ?int
    {
        return $this->repaymentAmount;
    }

    public function setRepaymentAmount(?int $repaymentAmount): self
    {
        $this->repaymentAmount = $repaymentAmount;

        return $this;
    }

    public function getExpertiseField(): ?string
    {
        return $this->expertiseField;
    }

    public function setExpertiseField(?string $expertiseField): self
    {
        $this->expertiseField = $expertiseField;

        return $this;
    }

    public function getReferenceProjects(): ?string
    {
        return $this->referenceProjects;
    }

    public function setReferenceProjects(?string $referenceProjects): self
    {
        $this->referenceProjects = $referenceProjects;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCollege(): ?College
    {
        return $this->college;
    }

    public function setCollege(?College $college): self
    {
        $this->college = $college;

        return $this;
    }

    public function getLegalPerson(): ?LegalPerson
    {
        return $this->legalPerson;
    }

    public function setLegalPerson(?LegalPerson $legalPerson): self
    {
        $this->legalPerson = $legalPerson;

        return $this;
    }

    public function getNaturalPerson(): ?NaturalPerson
    {
        return $this->naturalPerson;
    }

    public function setNaturalPerson(?NaturalPerson $naturalPerson): self
    {
        $this->naturalPerson = $naturalPerson;

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

    public function formatDate(?\DateTimeInterface $date)
    {
        if ($date != null) {
            return date_format($date, 'd-m-Y');
        }

        return null;
    }

    public function convertNameTable($name)
    {
        if ($name != null) {
            return $name;
        }

        return '';
    }
}
