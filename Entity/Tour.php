<?php

namespace Svs\Core\Entity;

use Svs\Core\Entity\MediaObject;
use Svs\Core\Repository\TourRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

use Locastic\ApiPlatformTranslationBundle\Model\AbstractTranslatable;
use Locastic\ApiPlatformTranslationBundle\Model\TranslationInterface;

/**
 * @ORM\Entity(repositoryClass=TourRepository::class)
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
class Tour extends AbstractTranslatable
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
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post_write", "translations"})
     */
    private $reference;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"post_write", "translations"})
     */
    private $daysNumber;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"post_write", "translations"})
     */
    private $nightsNumber;

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
     * @ORM\OneToMany(targetEntity="TourTranslation", mappedBy="translatable", fetch="EXTRA_LAZY", indexBy="locale", cascade={"PERSIST"}, orphanRemoval=true)
     *
     * @Groups({"post_write", "translations"})
     */
    protected $translations;

    /**
     * @ORM\ManyToMany(targetEntity=RouteStage::class)
     *
     * @Groups({"post_write", "translations"})
     */
    private $routeStages;

    /**
     * @ORM\Column(type="json", nullable=true)
     *
     * @Groups({"post_write", "translations"})
     */
    private $itinerary = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     *
     * @Groups({"post_write", "translations"})
     */
    private $prices = [];

    /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class, fetch="EAGER")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @ApiProperty(iri="http://schema.org/image")
     * @Groups({"tour_read", "post_read", "post_write", "translations"})
     */
    public $mainImage;

    /**
     * @ORM\ManyToOne(targetEntity=Pack::class, inversedBy="tours")
     */
    private $pack;

    public function __construct()
    {
        $this->routeStages = new ArrayCollection();

        parent::__construct();
    }

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

    public function getDescription(): ?string
    {
        return $this->getTranslation()->getDescription();
    }

    public function setDescription(string $description): void
    {
        $this->getTranslation()->setDescription($description);
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

    public function getDaysNumber(): ?int
    {
        return $this->daysNumber;
    }

    public function setDaysNumber(int $daysNumber): self
    {
        $this->daysNumber = $daysNumber;

        return $this;
    }

    public function getNightsNumber(): ?int
    {
        return $this->nightsNumber;
    }

    public function setNightsNumber(int $nightsNumber): self
    {
        $this->nightsNumber = $nightsNumber;

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

    /**
     * @return Collection<int, RouteStage>
     */
    public function getRouteStages(): Collection
    {
        return $this->routeStages;
    }

    public function setRouteStages($routeStages): self
    {
        $this->routeStages = $routeStages;

        return $this;
    }

    public function addRouteStage(RouteStage $routeStage): self
    {
        if (!$this->routeStages->contains($routeStage)) {
            $this->routeStages[] = $routeStage;
        }

        return $this;
    }

    public function removeRouteStage(RouteStage $routeStage): self
    {
        $this->routeStages->removeElement($routeStage);

        return $this;
    }

    public function getItinerary(): ?array
    {
        return $this->itinerary;
    }

    public function setItinerary(?array $itinerary): self
    {
        $this->itinerary = $itinerary;

        return $this;
    }

    public function getPrices(): ?array
    {
        return $this->prices;
    }

    public function setPrices(?array $prices): self
    {
        $this->prices = $prices;

        return $this;
    }

    protected function createTranslation(): TranslationInterface
    {
        return new TourTranslation();
    }

    public function getPack(): ?Pack
    {
        return $this->pack;
    }

    public function setPack(?Pack $pack): self
    {
        $this->pack = $pack;

        return $this;
    }
}
