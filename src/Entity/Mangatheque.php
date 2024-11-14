<?php

namespace App\Entity;

use App\Repository\MangathequeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MangathequeRepository::class)]
class Mangatheque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "string", nullable: false)]
    private string $description;

    #[ORM\Column(type: "boolean", nullable: false)]
    private bool $publiee;

    #[ORM\ManyToOne(inversedBy: 'Mangashelf')]
    private ?Member $member = null;

    /**
     * @var Collection<int, Manga>
     */
    #[ORM\ManyToMany(targetEntity: Manga::class, inversedBy: 'mangatheques')]
    private Collection $mangas;

    public function __construct()
    {
        $this->mangas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isPubliee(): bool
    {
        return $this->publiee;
    }

    public function setPubliee(bool $publiee): static
    {
        $this->publiee = $publiee;

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): static
    {
        $this->member = $member;

        return $this;
    }

    /**
     * @return Collection<int, Manga>
     */
    public function getMangas(): Collection
    {
        return $this->mangas;
    }

    public function addManga(Manga $manga): static
    {
        if (!$this->mangas->contains($manga)) {
            $this->mangas->add($manga);
        }

        return $this;
    }

    public function removeManga(Manga $manga): static
    {
        $this->mangas->removeElement($manga);

        return $this;
    }
}
