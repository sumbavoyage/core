<?php

namespace Svs\Core\Entity;

use Svs\Core\Entity\MediaObject;
use Svs\Core\Repository\LandRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;

use Locastic\ApiPlatformTranslationBundle\Model\AbstractTranslatable;
use Locastic\ApiPlatformTranslationBundle\Model\TranslationInterface;

/**
 * @ORM\Entity(repositoryClass=LandRepository::class)
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
class Land extends AbstractTranslatable
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
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"post_write", "translations"})
     */
    private $squareMetersArea;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"post_write", "translations"})
     */
    private $hasAgent;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"post_write", "translations"})
     */
    private $hasRoad;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"post_write", "translations"})
     */
    private $hasElectricity;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"post_write", "translations"})
     */
    private $hasCertificate;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"post_write", "translations"})
     */
    private $certificateCount;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"post_write", "translations"})
     */
    private $certificateDate;

    /**
     * @Groups({"post_read"})
     */
    private $introText1;

    /**
     * @Groups({"post_read"})
     */
    private $introText2;

    /**
     * @Groups({"post_read"})
     */
    private $introText3;

    /**
     * @Groups({"post_read"})
     */
    private $faqTitle1;

    /**
     * @Groups({"post_read"})
     */
    private $faqText1;

    /**
     * @Groups({"post_read"})
     */
    private $faqTitle2;

    /**
     * @Groups({"post_read"})
     */
    private $faqText2;

    /**
     * @Groups({"post_read"})
     */
    private $faqTitle3;

    /**
     * @Groups({"post_read"})
     */
    private $faqText3;

    /**
     * @Groups({"post_read"})
     */
    private $faqTitle4;

    /**
     * @Groups({"post_read"})
     */
    private $faqText4;

    /**
     * @Groups({"post_read"})
     */
    private $faqTitle5;

    /**
     * @Groups({"post_read"})
     */
    private $faqText5;

    /**
     * @Groups({"post_read"})
     */
    private $faqTitle6;

    /**
     * @Groups({"post_read"})
     */
    private $faqText6;

    /**
     * @Groups({"post_read"})
     */
    private $priceText;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"post_write", "translations"})
     */
    private $price;

    /**
     * @Groups({"post_read"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"post_write", "translations"})
     */
    private $googleMapUrl;

    /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class, fetch="EAGER")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @ApiProperty(iri="http://schema.org/image")
     * @Groups({"land_read", "post_read", "post_write", "translations"})
     */
    public $mainImage;

    /**
     * @ORM\OneToMany(targetEntity=MediaObject::class, mappedBy="land")
     * @Groups({"post_write", "translations"})
     */
    public $images;

    /**
     * @ORM\OneToMany(targetEntity="LandTranslation", mappedBy="translatable", fetch="EXTRA_LAZY", indexBy="locale", cascade={"PERSIST"}, orphanRemoval=true)
     *
     * @Groups({"post_write", "translations"})
     */
    protected $translations;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->getTranslation()->getName();
    }

    public function setName(string $name): self
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

    public function getSquareMetersArea(): ?int
    {
        return $this->squareMetersArea;
    }

    public function setSquareMetersArea(?int $squareMetersArea): self
    {
        $this->squareMetersArea = $squareMetersArea;

        return $this;
    }

    public function isHasAgent(): ?bool
    {
        return $this->hasAgent;
    }

    public function setHasAgent(bool $hasAgent): self
    {
        $this->hasAgent = $hasAgent;

        return $this;
    }

    public function isHasRoad(): ?bool
    {
        return $this->hasRoad;
    }

    public function setHasRoad(bool $hasRoad): self
    {
        $this->hasRoad = $hasRoad;

        return $this;
    }

    public function isHasElectricity(): ?bool
    {
        return $this->hasElectricity;
    }

    public function setHasElectricity(bool $hasElectricity): self
    {
        $this->hasElectricity = $hasElectricity;

        return $this;
    }

    public function isHasCertificate(): ?bool
    {
        return $this->hasCertificate;
    }

    public function setHasCertificate(bool $hasCertificate): self
    {
        $this->hasCertificate = $hasCertificate;

        return $this;
    }

    public function getCertificateCount(): ?int
    {
        return $this->certificateCount;
    }

    public function setCertificateCount(int $certificateCount): self
    {
        $this->certificateCount = $certificateCount;

        return $this;
    }

    public function getCertificateDate(): ?\DateTimeInterface
    {
        return $this->certificateDate;
    }

    public function setCertificateDate(?\DateTimeInterface $certificateDate): self
    {
        $this->certificateDate = $certificateDate;

        return $this;
    }

    public function getIntroText1(): ?string
    {
        return $this->getTranslation()->getIntroText1();
    }

    public function setIntroText1(?string $introText1): self
    {
        $this->getTranslation()->setIntroText1($introText1);
    }

    public function getIntroText2(): ?string
    {
        return $this->getTranslation()->getIntroText2();
    }

    public function setIntroText2(?string $introText2): self
    {
        $this->getTranslation()->setIntroText2($introText2);
    }

    public function getIntroText3(): ?string
    {
        return $this->getTranslation()->getIntroText3();
    }

    public function setIntroText3(?string $introText3): self
    {
        $this->getTranslation()->setIntroText3($introText3);
    }

    public function getFaqTitle1(): ?string
    {
        return $this->getTranslation()->getFaqTitle1();
    }

    public function setFaqTitle1(?string $faqTitle1): self
    {
        $this->getTranslation()->setFaqTitle1($faqTitle1);
    }

    public function getFaqText1(): ?string
    {
        return $this->getTranslation()->getFaqText1();
    }

    public function setFaqText1(?string $faqText1): self
    {
        $this->getTranslation()->setFaqText1($faqText1);
    }

    public function getFaqTitle2(): ?string
    {
        return $this->getTranslation()->getFaqTitle2();
    }

    public function setFaqTitle2(?string $faqTitle2): self
    {
        $this->getTranslation()->setFaqTitle2($faqTitle2);
    }

    public function getFaqText2(): ?string
    {
        return $this->getTranslation()->getFaqText2();
    }

    public function setFaqText2(?string $faqText2): self
    {
        $this->getTranslation()->setFaqText2($faqText2);
    }

    public function getFaqTitle3(): ?string
    {
        return $this->getTranslation()->getFaqTitle3();
    }

    public function setFaqTitle3(?string $faqTitle3): self
    {
        $this->getTranslation()->setFaqTitle3($faqTitle3);
    }

    public function getFaqText3(): ?string
    {
        return $this->getTranslation()->getFaqText3();
    }

    public function setFaqText3(?string $faqText3): self
    {
        $this->getTranslation()->setFaqText3($faqText3);
    }

    public function getFaqTitle4(): ?string
    {
        return $this->getTranslation()->getFaqTitle4();
    }

    public function setFaqTitle4(?string $faqTitle4): self
    {
        $this->getTranslation()->setFaqTitle4($faqTitle4);
    }

    public function getFaqText4(): ?string
    {
        return $this->getTranslation()->getFaqText4();
    }

    public function setFaqText4(?string $faqText4): self
    {
        $this->getTranslation()->setFaqText4($faqText4);
    }

    public function getFaqTitle5(): ?string
    {
        return $this->getTranslation()->getFaqTitle5();
    }

    public function setFaqTitle5(?string $faqTitle5): self
    {
        $this->getTranslation()->setFaqTitle5($faqTitle5);
    }

    public function getFaqText5(): ?string
    {
        return $this->getTranslation()->getFaqText5();
    }

    public function setFaqText5(?string $faqText5): self
    {
        $this->getTranslation()->setFaqText5($faqText5);
    }

    public function getFaqTitle6(): ?string
    {
        return $this->getTranslation()->getFaqTitle6();
    }

    public function setFaqTitle6(?string $faqTitle6): self
    {
        $this->getTranslation()->setFaqTitle6($faqTitle6);
    }

    public function getFaqText6(): ?string
    {
        return $this->getTranslation()->getFaqText6();
    }

    public function setFaqText6(?string $faqText6): self
    {
        $this->getTranslation()->setFaqText6($faqText6);
    }

    public function getPriceText(): ?string
    {
        return $this->getTranslation()->getPriceText();
    }

    public function setPriceText(?string $priceText): self
    {
        $this->getTranslation()->setPriceText($priceText);
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->getTranslation()->getDescription();
    }

    public function setDescription(string $description): self
    {
        $this->getTranslation()->setDescription($description);
    }

    public function getGoogleMapUrl(): ?string
    {
        return $this->googleMapUrl;
    }

    public function setGoogleMapUrl(?string $googleMapUrl): self
    {
        $this->googleMapUrl = $googleMapUrl;

        return $this;
    }

    protected function createTranslation(): TranslationInterface
    {
        return new LandTranslation();
    }

    public function __toString()
    {
        return $this->getName();
    }
}
