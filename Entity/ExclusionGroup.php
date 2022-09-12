<?php

namespace Svs\Core\Entity;

use Svs\Core\Repository\ExclusionGroupRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ExclusionGroupRepository::class)
 * @ApiResource(
 *     attributes={
 *         "filters"={"translation.groups"},
 *         "normalization_context"={"groups":{"exclusion_group"}},
 *         "denormalization_context"={"groups":{"post_write"}}
 *     },
 *     itemOperations={
 *         "get"={
 *             "method"="GET"
 *         },
 *         "put"={
 *             "method"="PUT",
 *             "normalization_context"={"groups":{"translations"}}
 *         }
 *     },
 *     collectionOperations={
 *         "get"={
 *             "method"="GET"
 *         },
 *         "post"={
 *             "method"="POST",
 *             "normalization_context"={"groups":{"translations"}}
 *         }
 *     }
 * )
 */
class ExclusionGroup
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"exclusion_group", "post_write", "translations"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Exclusion::class, mappedBy="exclusionGroup")
     * @Groups({"exclusion_group", "post_write", "translations"})
     */
    private $exclusions;

    public function __construct()
    {
        $this->exclusions = new ArrayCollection();
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

    /**
     * @return Collection<int, Exclusion>
     */
    public function getExclusions(): Collection
    {
        return $this->exclusions;
    }

    public function addExclusion(Exclusion $exclusion): self
    {
        if (!$this->exclusions->contains($exclusion)) {
            $this->exclusions[] = $exclusion;
            $exclusion->setExclusionGroup($this);
        }

        return $this;
    }

    public function removeExclusion(Exclusion $exclusion): self
    {
        if ($this->exclusions->removeElement($exclusion)) {
            // set the owning side to null (unless already changed)
            if ($exclusion->getExclusionGroup() === $this) {
                $exclusion->setExclusionGroup(null);
            }
        }

        return $this;
    }
}
