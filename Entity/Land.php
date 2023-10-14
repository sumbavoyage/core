<?php

namespace Svs\Core\Entity;

use Svs\Core\Entity\MediaObject;
use Svs\Core\Repository\LandRepository;
use Doctrine\ORM\Mapping as ORM;
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
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"post_write", "translations"})
     */
    private $squareMetersArea;

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
     * @ORM\Column(type="integer")
     * @Groups({"post_write", "translations"})
     */
    private $price;

    /**
     * @Groups({"post_read"})
     */
    private $description;

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
     * @ORM\OneToMany(targetEntity="LandTranslation", mappedBy="translatable", fetch="EXTRA_LAZY", indexBy="locale", cascade={"PERSIST"}, orphanRemoval=true)
     *
     * @Groups({"post_write", "translations"})
     */
    protected $translations;

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

    public function getSquareMetersArea(): ?int
    {
        return $this->squareMetersArea;
    }

    public function setSquareMetersArea(?int $squareMetersArea): self
    {
        $this->squareMetersArea = $squareMetersArea;

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

    protected function createTranslation(): TranslationInterface
    {
        return new LandTranslation();
    }
}
