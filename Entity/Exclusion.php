<?php

namespace Svs\Core\Entity;

use Svs\Core\Repository\ExclusionRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

use Locastic\ApiPlatformTranslationBundle\Model\AbstractTranslatable;
use Locastic\ApiPlatformTranslationBundle\Model\TranslationInterface;

/**
 * @ORM\Entity(repositoryClass=ExclusionRepository::class)
 * @ApiResource(
 *     attributes={
 *         "filters"={"translation.groups"},
 *         "normalization_context"={"groups":{"exclusion_group"}},
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
class Exclusion extends AbstractTranslatable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"exclusion_group", "post_read"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="ExclusionTranslation", mappedBy="translatable", fetch="EXTRA_LAZY", indexBy="locale", cascade={"PERSIST"}, orphanRemoval=true)
     *
     * @Groups({"exclusion_group", "post_write", "translations"})
     */
    protected $translations;

    /**
     * @ORM\ManyToOne(targetEntity=ExclusionGroup::class, inversedBy="exclusions")
     */
    private $exclusionGroup;

    public function __construct()
    {
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

    protected function createTranslation(): TranslationInterface
    {
        return new ExclusionTranslation();
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
}
