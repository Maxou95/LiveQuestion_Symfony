<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $category;

    /**
     * @ORM\Column(type="integer", options={"default": "0"})
     */
    private $views = 0;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $created;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Answer", mappedBy="question", orphanRemoval=true, fetch="EXTRA_LAZY")
     */
    private $answers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuestionLike", mappedBy="question", orphanRemoval=true)
     */
    private $questionLikes;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|QuestionLike[]
     */
    public function getQuestionLikes(): Collection
    {
        return $this->questionLikes;
    }

    public function addQuestionLike(QuestionLike $questionLikes): self
    {
        if (!$this->questionLikes->contains($questionLikes)) {
            $this->questionLikes[] = $questionLikes;
            $questionLikes->setQuestion($this);
        }

        return $this;
    }

    public function removeQuestionLike(QuestionLike $questionLikes): self
    {
        if ($this->questionLikes->contains($questionLikes)) {
            $this->questionLikes->removeElement($questionLikes);
            // set the owning side to null (unless already changed)
            if ($questionLikes->getQuestion() === $this) {
                $questionLikes->setQuestion(null);
            }
        }

        return $this;
    }

    public function isLikedByUser(User $user) : bool
    {
        foreach($this->questionLikes as $like) {
            if($like->getUser() === $user) return true;
        }

        return false;
    }

}
