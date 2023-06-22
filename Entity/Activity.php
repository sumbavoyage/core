<?php

namespace Svs\Core\Entity;

use Svs\Core\Entity\MediaObject;
use Svs\Core\Repository\ActivityRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

use Locastic\ApiPlatformTranslationBundle\Model\AbstractTranslatable;
use Locastic\ApiPlatformTranslationBundle\Model\TranslationInterface;

/**
 * @ORM\Entity(repositoryClass=ActivityRepository::class)
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
class Activity extends AbstractTranslatable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"post_read"})
     */
    private $name;

    /**
     * @Groups({"post_read"})
     */
    private $slug;

    /**
     * @Groups({"post_read"})
     */
    private $shortDescription;

    /**
     * @Groups({"post_read"})
     */
    private $description;

    /**
     * @Groups({"post_read"})
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post_write", "translations"})
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post_write", "translations"})
     */
    private $duration;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"post_write", "translations"})
     */
    private $minimumPax;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"post_write", "translations"})
     */
    private $maximumPax;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post_write", "translations"})
     */
    private $meetingPointAddress;

    /**
     * @ORM\Column(type="float")
     * @Groups({"post_write", "translations"})
     */
    private $meetingPointLat;

    /**
     * @ORM\Column(type="float")
     * @Groups({"post_write", "translations"})
     */
    private $meetingPointLng;

    /**
     * @ORM\ManyToOne(targetEntity=CancellationPolicy::class, fetch="EAGER")
     * @Groups({"post_write", "translations"})
     */
    private $cancellationPolicy;

    /**
     * @ORM\ManyToOne(targetEntity=InclusionGroup::class, fetch="EAGER")
     * @Groups({"post_write", "translations"})
     */
    private $inclusionGroup;

    /**
     * @ORM\ManyToOne(targetEntity=ExclusionGroup::class, fetch="EAGER")
     * @Groups({"post_write", "translations"})
     */
    private $exclusionGroup;

    /**
     * @ORM\OneToMany(targetEntity="ActivityTranslation", mappedBy="translatable", fetch="EXTRA_LAZY", indexBy="locale", cascade={"PERSIST"}, orphanRemoval=true)
     *
     * @Groups({"post_write", "translations"})
     */
    protected $translations;

    /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class, fetch="EAGER")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @ApiProperty(iri="http://schema.org/image")
     * @Groups({"post_read", "post_write", "translations"})
     */
    public $mainImage;

    /**
     * @ORM\ManyToOne(targetEntity=Advert::class, fetch="EAGER")
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $advert;

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

    public function getSlug(): ?string
    {
        return $this->getTranslation()->getSlug();
    }

    public function setSlug(string $slug): void
    {
        $this->getTranslation()->setSlug($slug);
    }

    public function getShortDescription(): ?string
    {
        return $this->getTranslation()->getShortDescription();
    }

    public function setShortDescription(string $description): void
    {
        $this->getTranslation()->setShortDescription($description);
    }

    public function getDescription(): ?string
    {
        return $this->getTranslation()->getDescription();
    }

    public function setDescription(string $description): void
    {
        $this->getTranslation()->setDescription($description);
    }

    public function getPrice(): ?string
    {
        return $this->getTranslation()->getPrice();
    }

    public function setPrice(?string $price): void
    {
        $this->getTranslation()->setPrice($price);
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(?string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getMinimumPax(): ?int
    {
        return $this->minimumPax;
    }

    public function setMinimumPax(?int $minimumPax): self
    {
        $this->minimumPax = $minimumPax;

        return $this;
    }

    public function getMaximumPax(): ?int
    {
        return $this->maximumPax;
    }

    public function setMaximumPax(?int $maximumPax): self
    {
        $this->maximumPax = $maximumPax;

        return $this;
    }

    public function getMeetingPointAddress(): ?string
    {
        return $this->meetingPointAddress;
    }

    public function setMeetingPointAddress(string $meetingPointAddress): self
    {
        $this->meetingPointAddress = $meetingPointAddress;

        return $this;
    }

    public function getMeetingPointLat(): ?float
    {
        return $this->meetingPointLat;
    }

    public function setMeetingPointLat(float $meetingPointLat): self
    {
        $this->meetingPointLat = $meetingPointLat;

        return $this;
    }

    public function getMeetingPointLng(): ?float
    {
        return $this->meetingPointLng;
    }

    public function setMeetingPointLng(float $meetingPointLng): self
    {
        $this->meetingPointLng = $meetingPointLng;

        return $this;
    }

    public function getCancellationPolicy(): ?CancellationPolicy
    {
        return $this->cancellationPolicy;
    }

    public function setCancellationPolicy(?CancellationPolicy $cancellationPolicy): self
    {
        $this->cancellationPolicy = $cancellationPolicy;

        return $this;
    }

    public function getInclusionGroup(): ?InclusionGroup
    {
        return $this->inclusionGroup;
    }

    public function setInclusionGroup(?InclusionGroup $inclusionGroup): self
    {
        $this->inclusionGroup = $inclusionGroup;

        return $this;
    }

    public function getExclusionGroup(): ?ExclusionGroup
    {
        return $this->exclusionGroup;
    }

    public function setExclusionGroup(?ExclusionGroup $exclusionGroup): self
    {
        $this->exclusionGroup = $exclusionGroup;

        return $this;
    }

    protected function createTranslation(): TranslationInterface
    {
        return new ActivityTranslation();
    }

    public function getAdvert(): ?Advert
    {
        return $this->advert;
    }

    public function setAdvert(?Advert $advert): self
    {
        $this->advert = $advert;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
