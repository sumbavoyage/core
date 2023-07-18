<?php

namespace Svs\Core\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 * @ApiResource(
 *     attributes={
 *         "filters"={"translation.groups"},
 *         "normalization_context"={"groups":{"post_read"}},
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
class Setting
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reviewsCount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reviewsScore;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReviewsCount(): ?int
    {
        return $this->reviewsCount;
    }

    public function setReviewsCount(?int $reviewsCount): self
    {
        $this->reviewsCount = $reviewsCount;

        return $this;
    }

    public function getReviewsScore(): ?int
    {
        return $this->reviewsScore;
    }

    public function setReviewsScore(?int $reviewsScore): self
    {
        $this->reviewsScore = $reviewsScore;

        return $this;
    }

    public function __toString()
    {
        return $this->getId();
    }
}
