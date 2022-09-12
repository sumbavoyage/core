<?php

namespace Svs\Core\Entity;

use Svs\Core\Repository\InclusionGroupRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=InclusionGroupRepository::class)
 * @ApiResource(
 *     attributes={
 *         "filters"={"translation.groups"},
 *         "normalization_context"={"groups":{"inclusion_group"}},
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
class InclusionGroup
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"inclusion_group", "post_write", "translations"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Inclusion::class, mappedBy="inclusionGroup")
     * @Groups({"inclusion_group", "post_write", "translations"})
     */
    private $inclusions;

    public function __construct()
    {
        $this->inclusions = new ArrayCollection();
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
     * @return Collection<int, Inclusion>
     */
    public function getInclusions(): Collection
    {
        return $this->inclusions;
    }

    public function addInclusion(Inclusion $inclusion): self
    {
        if (!$this->inclusions->contains($inclusion)) {
            $this->inclusions[] = $inclusion;
            $inclusion->setInclusionGroup($this);
        }

        return $this;
    }

    public function removeInclusion(Inclusion $inclusion): self
    {
        if ($this->inclusions->removeElement($inclusion)) {
            // set the owning side to null (unless already changed)
            if ($inclusion->getInclusionGroup() === $this) {
                $inclusion->setInclusionGroup(null);
            }
        }

        return $this;
    }
}
