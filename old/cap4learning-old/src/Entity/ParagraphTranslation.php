<?php

namespace App\Entity;

use App\Entity\SonataMediaBundle\Media;
use App\Repository\ParagraphRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;

/**
 * @ORM\Entity(repositoryClass=ParagraphRepository::class)
 */
class ParagraphTranslation implements TranslationInterface
{
    use TranslationTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $textColumn1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $textColumn2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $feature;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTextColumn1(): ?string
    {
        return $this->textColumn1 ?? ' ';
    }

    public function setTextColumn1(?string $textColumn1): self
    {
        if (!$textColumn1) {
            $textColumn1 = ' ';
        }

        $this->textColumn1 = $textColumn1;

        return $this;
    }

    public function getTextColumn2(): ?string
    {
        return $this->textColumn2 ?? ' ';
    }

    public function setTextColumn2(?string $textColumn2): self
    {
        if (!$textColumn2) {
            $textColumn2 = ' ';
        }

        $this->textColumn2 = $textColumn2;

        return $this;
    }

    public function getFeature(): ?string
    {
        return $this->feature ?? ' ';
    }

    public function setFeature(?string $feature): self
    {
        if (!$feature) {
            $feature = ' ';
        }

        $this->feature = $feature;

        return $this;
    }
}
