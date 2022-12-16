<?php

namespace Svs\Core\Entity;

use Svs\Core\Repository\AdvertRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * @ORM\Entity(repositoryClass=AdvertRepository::class)
 * @ApiResource(
 *     attributes={
 *         "filters"={"translation.groups"},
 *         "normalization_context"={"groups":{"advert_read", "post_read"}},
 *         "denormalization_context"={"groups":{"advert_write", "post_write"}}
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
class Advert
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post_write", "translations"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post_write", "translations"})
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity=AdvertMedia::class, mappedBy="advert")
     * @Groups({"post_write", "translations"})
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, AdvertMedia>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(AdvertMedia $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
        }

        return $this;
    }

    public function removeImage(AdvertMedia $image): self
    {
        $this->images->removeElement($image);

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
