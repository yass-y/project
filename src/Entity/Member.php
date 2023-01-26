<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
#[ORM\Table(name: '`member`')]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fullname = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $birthday = null;

    #[ORM\Column(length: 255)]
    private ?string $department = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'memberProspecting', targetEntity: Prospecting::class)]
    private Collection $prospecting;

    public function __construct()
    {
        $this->prospecting = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getBirthday(): ?\DateTimeImmutable
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeImmutable $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(string $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Prospecting>
     */
    public function getProspecting(): Collection
    {
        return $this->prospecting;
    }

    public function addProspecting(Prospecting $prospecting): self
    {
        if (!$this->prospecting->contains($prospecting)) {
            $this->prospecting->add($prospecting);
            $prospecting->setMemberProspecting($this);
        }

        return $this;
    }

    public function removeProspecting(Prospecting $prospecting): self
    {
        if ($this->prospecting->removeElement($prospecting)) {
            // set the owning side to null (unless already changed)
            if ($prospecting->getMemberProspecting() === $this) {
                $prospecting->setMemberProspecting(null);
            }
        }

        return $this;
    }
}
