<?php

namespace App\Entity;

use App\Repository\MangaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MangaRepository::class)]
class Manga
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Author = null;

    #[ORM\ManyToOne(inversedBy: 'mangas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Mangashelf $mangashelf = null;

    /**
     * @var Collection<int, Mangatheque>
     */
    #[ORM\ManyToMany(targetEntity: Mangatheque::class, mappedBy: 'mangas')]
    private Collection $mangatheques;

    public function __construct()
    {
        $this->mangatheques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->Author;
    }

    public function setAuthor(string $Author): static
    {
        $this->Author = $Author;

        return $this;
    }

    public function getMangashelf(): ?Mangashelf
    {
        return $this->mangashelf;
    }

    public function setMangashelf(?Mangashelf $mangashelf): static
    {
        $this->mangashelf = $mangashelf;

        return $this;
    }

    /**
     * @return Collection<int, Mangatheque>
     */
    public function getMangatheques(): Collection
    {
        return $this->mangatheques;
    }

    public function addMangatheque(Mangatheque $mangatheque): static
    {
        if (!$this->mangatheques->contains($mangatheque)) {
            $this->mangatheques->add($mangatheque);
            $mangatheque->addManga($this);
        }

        return $this;
    }

    public function removeMangatheque(Mangatheque $mangatheque): static
    {
        if ($this->mangatheques->removeElement($mangatheque)) {
            $mangatheque->removeManga($this);
        }

        return $this;
    }
}
