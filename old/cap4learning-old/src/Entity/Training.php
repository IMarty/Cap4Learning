<?php

namespace App\Entity;

use App\Entity\SonataMediaBundle\Media;
use App\Entity\Traits\TimeStampableTrait;
use App\Repository\TrainingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @ORM\Entity(repositoryClass=TrainingRepository::class)
 */
class Training implements TranslatableInterface
{
    use TimeStampableTrait;
    use TranslatableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Media::class, cascade={"persist"})
     */
    private $picture;

    /**
     * @ORM\Column(type="boolean")
     */
    private $eligibleCpf;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $priceInter;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $priceIntra;

    /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    /**
     * @ORM\ManyToOne(targetEntity=TrainingCategory::class, inversedBy="trainings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToOne(targetEntity=Media::class, cascade={"persist", "remove"})
     */
    private $file;

    /**
     * @ORM\OneToMany(targetEntity=Module::class, mappedBy="training", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $modules;

    /**
     * @ORM\Column(type="integer")
     */
    private $weight;

    /**
     * @ORM\Column(type="integer")
     */
    private $durationDays;

    /**
     * @ORM\Column(type="integer")
     */
    private $DurationHours;

    /**
     * @ORM\Column(type="integer", nullable=true))
     */
    private $traineeNumberMin;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $traineeNumberMax;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $nextDate;

    /**
     * @ORM\OneToMany(targetEntity=TrainingSession::class, mappedBy="training", orphanRemoval=true, cascade={"persist"})
     */
    private $sessions;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->modules = new ArrayCollection();
        $this->sessions = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        return $this->getTitle();
    }

    public function __call($method, $arguments)
    {
        return \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPicture(): ?Media
    {
        return $this->picture;
    }

    public function setPicture(?Media $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getEligibleCpf(): ?bool
    {
        return $this->eligibleCpf;
    }

    public function setEligibleCpf(bool $eligibleCpf): self
    {
        $this->eligibleCpf = $eligibleCpf;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getPriceIntra(): ?float
    {
        return $this->priceIntra;
    }

    public function setPriceIntra(?float $priceIntra): self
    {
        $this->priceIntra = $priceIntra;

        return $this;
    }

    public function getPriceInter(): ?float
    {
        return $this->priceInter;
    }

    public function setPriceInter(?float $priceInter): self
    {
        $this->priceInter = $priceInter;

        return $this;
    }

    public function getCategory(): ?TrainingCategory
    {
        return $this->category;
    }

    public function setCategory(?TrainingCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getNextDate(): ?\DateTime
    {
        return $this->nextDate;
    }

    public function setNextDate(?\DateTime $nextDate): self
    {
        $this->nextDate = $nextDate;

        return $this;
    }

    public function getFile(): ?Media
    {
        return $this->file;
    }

    public function setFile(?Media $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return Collection|Module[]
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules[] = $module;
            $module->setTraining($this);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->modules->removeElement($module)) {
            // set the owning side to null (unless already changed)
            if ($module->getTraining() === $this) {
                $module->setTraining(null);
            }
        }

        return $this;
    }

    public function getDurationDays(): ?int
    {
        return $this->durationDays;
    }

    public function setDurationDays(int $durationDays): self
    {
        $this->durationDays = $durationDays;

        return $this;
    }

    public function getDurationHours(): ?int
    {
        return $this->DurationHours;
    }

    public function setDurationHours(int $DurationHours): self
    {
        $this->DurationHours = $DurationHours;

        return $this;
    }

    public function getTraineeNumberMin(): ?int
    {
        return $this->traineeNumberMin;
    }

    public function setTraineeNumberMin(?int $traineeNumberMin): self
    {
        $this->traineeNumberMin = $traineeNumberMin;

        return $this;
    }

    public function getTraineeNumberMax(): ?int
    {
        return $this->traineeNumberMax;
    }

    public function setTraineeNumberMax(?int $traineeNumberMax): self
    {
        $this->traineeNumberMax = $traineeNumberMax;

        return $this;
    }

    /**
     * @return Collection|TrainingSession[]
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(TrainingSession $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setTraining($this);
        }

        return $this;
    }

    public function removeSession(TrainingSession $session): self
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getTraining() === $this) {
                $session->setTraining(null);
            }
        }

        return $this;
    }

    public function getNextSession()
    {
        $nextDate = false;
        $today = new \DateTime();


        /** @var TrainingSession $session */
        foreach ($this->sessions as $session) {
            if ($session->getStartDate() > $today) {
                if ($nextDate) {
                    if ($session->getStartDate() < $nextDate->getStartDate()) {
                        $nextDate = $session;
                    }
                } else {
                    $nextDate = $session;
                }
            }
        }



        return $nextDate;
    }
}
