<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AccountBalanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: AccountBalanceRepository::class)]
class AccountBalance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    # Many accountType have One account.
    #[ORM\ManyToOne( targetEntity:self::class , inversedBy:'accountType' )]
    #[ORM\JoinColumn(name:'parent_id',  referencedColumnName :'id' , nullable:true)]
    private  self $account;

    
    #One ProductCategory has Many ProductCategories.
    #[ORM\OneToMany(targetEntity:self::class , mappedBy:'account' )]
    private  Collection $accountType ;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $code = null;

    #[ORM\Column]
    private ?int $status = null;



    public function __construct()
    {
        $this->accountType = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccount(): ?self
    {
        return $this->account;
    }

    public function setAccount(?self $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getAccountType(): ?Collection
    {
        return $this->accountType;
    }

    public function AccountType(self $accountType): self
    {
        if (!$this->accountType->contains($accountType)) {
            $this->accountType[] = $accountType;
            $accountType->setAccount($this);
        }

        return $this;
    }

    public function removeSousFamille(self $accountType): self
    {
        if ($this->accountType->contains($accountType)) {
            $this->accountType->removeElement($accountType);
            // set the owning side to null (unless already changed)
            if ($accountType->getAccount() === $this) {
                $accountType->getAccount(null);
            }
        }

        return $this;
    }



    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(?int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
