<?php

namespace Svs\Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Locastic\ApiPlatformTranslationBundle\Model\AbstractTranslation;

/**
 * @ORM\Entity()
 */
class FaqTranslation extends AbstractTranslation
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
     * @ORM\ManyToOne(targetEntity="Faq", inversedBy="translations")
     */
    protected $translatable;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $question;

    /**
     * @ORM\Column(type="text")
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $answer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(?string $question): void
    {
        $this->question = $question;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(?string $answer): void
    {
        $this->answer = $answer;
    }

    public function __toString()
    {
        return $this->question;
    }
}
