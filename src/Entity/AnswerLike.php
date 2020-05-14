<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnswerLikeRepository")
 */
class AnswerLike
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Answer", inversedBy="answerLikes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $answer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="answerLikes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswer(): ?Answer
    {
        return $this->answer;
    }

    public function setAnswer(?Answer $answer): self
    {
        $this->answer = $answer;

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
}
