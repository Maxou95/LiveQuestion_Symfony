<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnswerRepository")
 */
class Answer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Question", inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AnswerLike", mappedBy="answer", orphanRemoval=true)
     */
    private $answerLikes;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

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

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

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
     * @return Collection|AnswerLike[]
     */
    public function getAnswerLikes(): Collection
    {
        return $this->answerLikes;
    }

    public function addAnswerLike(AnswerLike $answerLikes): self
    {
        if (!$this->answerLikes->contains($answerLikes)) {
            $this->answerLikes[] = $answerLikes;
            $answerLikes->setAnswer($this);
        }

        return $this;
    }

    public function removeAnswerLike(AnswerLike $answerLikes): self
    {
        if ($this->answerLikes->contains($answerLikes)) {
            $this->answerLikes->removeElement($answerLikes);
            // set the owning side to null (unless already changed)
            if ($answerLikes->getAnswer() === $this) {
                $answerLikes->setAnswer(null);
            }
        }

        return $this;
    }

    public function isLikedByUser(User $user) : bool
    {
        foreach($this->answerLikes as $like) {
            if($like->getUser() === $user) return true;
        }

        return false;
    }
}
