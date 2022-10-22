<?php

namespace Svs\Core\Entity;

use Svs\Core\Repository\InclusionRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

use Locastic\ApiPlatformTranslationBundle\Model\AbstractTranslatable;
use Locastic\ApiPlatformTranslationBundle\Model\TranslationInterface;

/**
 * @ORM\Entity(repositoryClass=InclusionRepository::class)
 * @ApiResource(
 *     attributes={
 *         "filters"={"translation.groups"},
 *         "normalization_context"={"groups":{"inclusion_group"}},
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
class Inclusion extends AbstractTranslatable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"inclusion_group", "post_read"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="InclusionTranslation", mappedBy="translatable", fetch="EXTRA_LAZY", indexBy="locale", cascade={"PERSIST"}, orphanRemoval=true)
     *
     * @Groups({"inclusion_group", "post_write", "translations"})
     */
    protected $translations;

    /**
     * @ORM\ManyToOne(targetEntity=InclusionGroup::class, inversedBy="inclusions")
     */
    private $inclusionGroup;

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
        return new InclusionTranslation();
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

    public function __toString()
    {
        return $this->getName();
    }
}
