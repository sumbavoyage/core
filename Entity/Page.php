<?php

namespace Svs\Core\Entity;

use Svs\Core\Repository\PageRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

use Locastic\ApiPlatformTranslationBundle\Model\AbstractTranslatable;
use Locastic\ApiPlatformTranslationBundle\Model\TranslationInterface;

/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 * @ApiResource(
 *     attributes={
 *         "filters"={"translation.groups"},
 *         "normalization_context"={"groups":{"page_read", "post_read"}},
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
class Page extends AbstractTranslatable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"page_read", "post_read", "post_write", "translations"})
     */
    private $code;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @Groups({"page_read", "post_read", "post_write", "translations"})
     */
    private $seo = [];

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"page_read", "post_read", "post_write", "translations"})
     */
    private $route;

    /**
     * @Groups({"page_read", "post_read"})
     */
    private $title;

    /**
     * @Groups({"page_read", "post_read"})
     */
    private $description;

    /**
     * @Groups({"page_read", "post_read"})
     */
    private $h1;

    /**
     * @ORM\OneToMany(targetEntity="PageTranslation", mappedBy="translatable", fetch="EXTRA_LAZY", indexBy="locale", cascade={"PERSIST"}, orphanRemoval=true)
     * @Groups({"post_write", "translations"})
     */
    protected $translations;

    /**
     * @ORM\ManyToOne(targetEntity=Site::class)
     */
    private $site;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siteCode;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSeo(): ?array
    {
        return $this->seo;
    }

    public function setSeo(?array $seo): self
    {
        $this->seo = $seo;

        return $this;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->getTranslation()->getTitle();
    }

    public function setTitle(?string $title): self
    {
        $this->getTranslation()->setTitle($title);
    }

    public function getDescription(): ?string
    {
        return $this->getTranslation()->getDescription();
    }

    public function setDescription(string $description): void
    {
        $this->getTranslation()->setDescription($description);
    }

    public function getH1(): ?string
    {
        return $this->getTranslation()->getH1();
    }

    public function setH1(?string $h1): self
    {
        $this->getTranslation()->setH1($h1);
    }

    protected function createTranslation(): TranslationInterface
    {
        return new PageTranslation();
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getSiteCode(): ?string
    {
        return $this->siteCode;
    }

    public function setSiteCode(?string $siteCode): self
    {
        $this->siteCode = $siteCode;

        return $this;
    }
}
