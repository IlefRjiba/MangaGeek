<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Member implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(mappedBy: 'membre', cascade: ['persist', 'remove'])]
    private ?Mangashelf $mangashelf = null;

    /**
     * @var Collection<int, Mangatheque>
     */
    #[ORM\OneToMany(targetEntity: Mangatheque::class, mappedBy: 'member')]
    private Collection $mangatheques;

    #[ORM\Column(length: 255)]
    private ?string $name = "default";

    #[ORM\Column(length: 255)]
    private ?string $surname = "default";

    public function __construct()
    {
        $this->Mangashelf = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getMangashelf(): ?Mangashelf
    {
        return $this->mangashelf;
    }

    /**
     * @return Collection<int, Mangatheque>
     */
    public function getMangatheques(): Collection
    {
        return $this->mangatheques;
    }

    public function setMangashelf(Mangashelf $mangashelf): static
    {
        // set the owning side of the relation if necessary
        if ($mangashelf->getMembre() !== $this) {
            $mangashelf->setMembre($this);
        }

        $this->mangashelf = $mangashelf;

        return $this;
    }

    public function addMangatheque(Mangatheque $mangatheque): static
    {
        if (!$this->mangatheques->contains($mangatheque)) {
            $this->mangatheques->add($mangatheque);
            $mangatheque->setMember($this);
        }

        return $this;
    }

    public function removeMangatheque(Mangatheque $mangatheque): static
    {
        if ($this->mangatheques->removeElement($mangatheque)) {
            // set the owning side to null (unless already changed)
            if ($mangatheque->getMember() === $this) {
                $mangatheque->setMember(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }
}
