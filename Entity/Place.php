<?php

namespace Svs\Core\Entity;

use Svs\Core\Entity\MediaObject;
use Svs\Core\Repository\PlaceRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

use Locastic\ApiPlatformTranslationBundle\Model\AbstractTranslatable;
use Locastic\ApiPlatformTranslationBundle\Model\TranslationInterface;

/**
 * @ORM\Entity(repositoryClass=PlaceRepository::class)
 * @ApiResource(
 *     attributes={
 *         "filters"={"translation.groups"},
 *         "normalization_context"={"groups":{"place_read", "post_read"}},
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
class Place extends AbstractTranslatable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"place_read", "post_read"})
     */
    private $name;

    /**
     * @Groups({"place_read", "post_read"})
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"place_read", "post_read", "post_write", "translations"})
     */
    private $lat;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"place_read", "post_read", "post_write", "translations"})
     */
    private $lng;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"place_read", "post_read", "post_write", "translations"})
     */
    private $entranceFees;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"place_read", "post_read", "post_write", "translations"})
     */
    private $parkingFees;

    /**
     * @var MediaObject|null
     *
     * @ORM\OneToMany(targetEntity=MediaObject::class, mappedBy="place")
     * @ApiProperty(iri="http://schema.org/image")
     * @Groups({"place_read", "post_read", "post_write", "translations"})
     */
    public $images;

    /**
     * @ORM\OneToMany(targetEntity="PlaceTranslation", mappedBy="translatable", fetch="EXTRA_LAZY", indexBy="locale", cascade={"PERSIST"}, orphanRemoval=true)
     *
     * @Groups({"post_write", "translations"})
     */
    protected $translations;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->getTranslation()->getName();
    }

    public function setName(string $name): void
    {
        $this->getTranslation()->setName($name);
    }

    public function getDescription(): ?string
    {
        return $this->getTranslation()->getDescription();
    }

    public function setDescription(string $description): void
    {
        $this->getTranslation()->setDescription($description);
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(?float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(?float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    protected function createTranslation(): TranslationInterface
    {
        return new PlaceTranslation();
    }

    public function getEntranceFees(): ?int
    {
        return $this->entranceFees;
    }

    public function setEntranceFees(?int $entranceFees): self
    {
        $this->entranceFees = $entranceFees;

        return $this;
    }

    public function getParkingFees(): ?int
    {
        return $this->parkingFees;
    }

    public function setParkingFees(?int $parkingFees): self
    {
        $this->parkingFees = $parkingFees;

        return $this;
    }
}
