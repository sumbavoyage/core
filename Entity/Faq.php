<?php

namespace Svs\Core\Entity;

use Svs\Core\Repository\FaqRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

use Locastic\ApiPlatformTranslationBundle\Model\AbstractTranslatable;
use Locastic\ApiPlatformTranslationBundle\Model\TranslationInterface;

/**
 * @ORM\Entity(repositoryClass=FaqRepository::class)
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
class Faq extends AbstractTranslatable
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
    private $question;

    /**
     * @Groups({"post_read"})
     */
    private $answer;

    /**
     * @ORM\OneToMany(targetEntity="FaqTranslation", mappedBy="translatable", fetch="EXTRA_LAZY", indexBy="locale", cascade={"PERSIST"}, orphanRemoval=true)
     *
     * @Groups({"post_write", "translations"})
     */
    protected $translations;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->getTranslation()->getQuestion();
    }

    public function setQuestion(string $question): void
    {
        $this->getTranslation()->setQuestion($question);
    }

    public function getAnswer(): ?string
    {
        return $this->getTranslation()->getAnswer();
    }

    public function setAnswer(string $answer): void
    {
        $this->getTranslation()->setAnswer($answer);
    }

    protected function createTranslation(): TranslationInterface
    {
        return new FaqTranslation();
    }
}
