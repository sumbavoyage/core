<?php

namespace Svs\Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Locastic\ApiPlatformTranslationBundle\Model\AbstractTranslation;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 */
class LandTranslation extends AbstractTranslation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups({"post_write", "translations"})
     */
    protected $locale;

    /**
     * @ORM\ManyToOne(targetEntity="Land", inversedBy="translations")
     */
    protected $translatable;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Gedmo\Slug(fields={"slug"})
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $introText1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $introText2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $introText3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $faqTitle1;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $faqText1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $faqTitle2;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $faqText2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $faqTitle3;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $faqText3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $faqTitle4;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $faqText4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $faqTitle5;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $faqText5;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $faqTitle6;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $faqText6;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $priceText;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setIntroText1(?string $introText1): void
    {
        $this->introText1 = $introText1;
    }

    public function getIntroText1(): ?string
    {
        return $this->introText1;
    }

    public function setIntroText2(?string $introText2): void
    {
        $this->introText2 = $introText2;
    }

    public function getIntroText2(): ?string
    {
        return $this->introText2;
    }

    public function setIntroText3(?string $introText3): void
    {
        $this->introText3 = $introText3;
    }

    public function getIntroText3(): ?string
    {
        return $this->introText3;
    }

    public function setFaqTitle1(?string $faqTitle1): void
    {
        $this->faqTitle1 = $faqTitle1;
    }

    public function getFaqTitle1(): ?string
    {
        return $this->faqTitle1;
    }

    public function setFaqText1(?string $faqText1): void
    {
        $this->faqText1 = $faqText1;
    }

    public function getFaqText1(): ?string
    {
        return $this->faqText1;
    }

    public function setFaqTitle2(?string $faqTitle2): void
    {
        $this->faqTitle2 = $faqTitle2;
    }

    public function getFaqTitle2(): ?string
    {
        return $this->faqTitle2;
    }

    public function setFaqText2(?string $faqText2): void
    {
        $this->faqText2 = $faqText2;
    }

    public function getFaqText2(): ?string
    {
        return $this->faqText2;
    }

    public function setFaqTitle3(?string $faqTitle3): void
    {
        $this->faqTitle3 = $faqTitle3;
    }

    public function getFaqTitle3(): ?string
    {
        return $this->faqTitle3;
    }

    public function setFaqText3(?string $faqText3): void
    {
        $this->faqText3 = $faqText3;
    }

    public function getFaqText3(): ?string
    {
        return $this->faqText3;
    }

    public function setFaqTitle4(?string $faqTitle4): void
    {
        $this->faqTitle4 = $faqTitle4;
    }

    public function getFaqTitle4(): ?string
    {
        return $this->faqTitle4;
    }

    public function setFaqText4(?string $faqText4): void
    {
        $this->faqText4 = $faqText4;
    }

    public function getFaqText4(): ?string
    {
        return $this->faqText4;
    }

    public function setFaqTitle5(?string $faqTitle5): void
    {
        $this->faqTitle5 = $faqTitle5;
    }

    public function getFaqTitle5(): ?string
    {
        return $this->faqTitle5;
    }

    public function setFaqText5(?string $faqText5): void
    {
        $this->faqText5 = $faqText5;
    }

    public function getFaqText5(): ?string
    {
        return $this->faqText5;
    }

    public function setFaqTitle6(?string $faqTitle6): void
    {
        $this->faqTitle6 = $faqTitle6;
    }

    public function getFaqTitle6(): ?string
    {
        return $this->faqTitle6;
    }

    public function setFaqText6(?string $faqText6): void
    {
        $this->faqText6 = $faqText6;
    }

    public function getFaqText6(): ?string
    {
        return $this->faqText6;
    }

    public function setPriceText(?string $priceText): void
    {
        $this->priceText = $priceText;
    }

    public function getPriceText(): ?string
    {
        return $this->priceText;
    }

    public function __toString()
    {
        return $this->name;
    }
}
