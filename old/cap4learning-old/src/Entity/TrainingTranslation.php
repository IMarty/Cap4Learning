<?php

namespace App\Entity;

use App\Entity\SonataMediaBundle\Media;
use App\Entity\Traits\TimeStampableTrait;
use App\Repository\NewsRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class TrainingTranslation implements TranslationInterface
{
    use TranslationTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[a-z0-9-]+$/")
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shortDescription;

    /**
     * @ORM\Column(type="text")
     */
    private $longDescription;

    /**
     * @ORM\Column(type="text")
     */
    private $requirements;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $coveredSkills;

    /**
     * @ORM\Column(type="text")
     */
    private $audience;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $goals;

    /**
     * @ORM\Column(type="text")
     */
    private $methods;

    /**
     * @ORM\Column(type="text")
     */
    private $achievement;

    /**
     * @ORM\Column(type="text")
     */
    private $trainer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $metas;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getLongDescription(): ?string
    {
        return $this->longDescription;
    }

    public function setLongDescription(string $longDescription): self
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    public function getRequirements(): ?string
    {
        return $this->requirements;
    }

    public function setRequirements(String $requirements): self
    {
        $this->requirements = $requirements;

        return $this;
    }

    public function getCoveredSkills(): ?array
    {
        return $this->coveredSkills;
    }

    public function setCoveredSkills(?array $coveredSkills): self
    {
        $this->coveredSkills = $coveredSkills;

        return $this;
    }

    public function getAudience(): ?string
    {
        return $this->audience;
    }

    public function setAudience(String $audience): self
    {
        $this->audience = $audience;

        return $this;
    }

    public function getGoals(): ?array
    {
        return $this->goals;
    }

    public function setGoals(?array $goals): self
    {
        $this->goals = $goals;

        return $this;
    }

    public function getMethods(): ?String
    {
        return $this->methods;
    }

    public function setMethods(String $methods): self
    {
        $this->methods = $methods;

        return $this;
    }

    public function getAchievement(): ?String
    {
        return $this->achievement;
    }

    public function setAchievement(String $achievement): self
    {
        $this->achievement = $achievement;

        return $this;
    }

    public function getTrainer(): ?String
    {
        return $this->trainer;
    }

    public function setTrainer(String $trainer): self
    {
        $this->trainer = $trainer;

        return $this;
    }

    public function getMetas(): ?string
    {
        return $this->metas;
    }

    public function setMetas(?string $metas): self
    {
        $this->metas = $metas;

        return $this;
    }
}
