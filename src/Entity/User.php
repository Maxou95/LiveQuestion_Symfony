<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints;
use FOS\MessageBundle\Model\ParticipantInterface;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="Ce nom d'utilisateur est déja pris.")
 * @UniqueEntity(fields={"email"}, message="Cette adresse email est déja utilisée par un autre compte.")
 */
class User implements UserInterface, ParticipantInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
     * @ORM\Column(type="string", length=50, unique=true)
     * Constraints\NotBlank(message="Veuillez saisir une nom d'utilisateur.")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=180)
     * Constraints\NotBlank(message="Veuillez saisir une addresse email valide.")
     * Constraints\Email(message="Veuillez saisir une addresse email valide.")
     */
    private $email;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Question", mappedBy="user", orphanRemoval=true)
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Answer", mappedBy="user", orphanRemoval=true)
     */
    private $answers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuestionLike", mappedBy="user")
     */
    private $questionLikes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AnswerLike", mappedBy="user")
     */
    private $answerLikes;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Profile", mappedBy="user", cascade={"persist", "remove"})
     */
    private $profile;

    /**
     * @ORM\ManyToMany(targetEntity=Conversation::class, mappedBy="participants")
     */
    private $conversations;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->questionLikes = new ArrayCollection();
        $this->answerLikes = new ArrayCollection();
        $this->conversations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setUser($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            if ($question->getUser() === $this) {
                $question->setUser(null);
            }
        }

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
            $answer->setUser($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            if ($answer->getUser() === $this) {
                $answer->setUser(null);
            }
        }

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection|QuestionLike[]
     */
    public function getQuestionsLikes(): Collection
    {
        return $this->questionLikes;
    }

    public function addQuestionsLike(QuestionLike $questionLikes): self
    {
        if (!$this->questionLikes->contains($questionLikes)) {
            $this->questionLikes[] = $questionLikes;
            $questionLikes->setUser($this);
        }

        return $this;
    }

    public function removeQuestionsLike(QuestionLike $questionLikes): self
    {
        if ($this->questionLikes->contains($questionLikes)) {
            $this->questionLikes->removeElement($questionLikes);
            // set the owning side to null (unless already changed)
            if ($questionLikes->getUser() === $this) {
                $questionLikes->setUser(null);
            }
        }

        return $this;
    }

    public function addAnswersLike(AnswerLike $answerLikes): self
    {
        if (!$this->answerLikes->contains($answerLikes)) {
            $this->answerLikes[] = $answerLikes;
            $answerLikes->setUser($this);
        }

        return $this;
    }

    public function removeAnswersLike(AnswerLike $answerLikes): self
    {
        if ($this->answerLikes->contains($answerLikes)) {
            $this->answerLikes->removeElement($answerLikes);
            // set the owning side to null (unless already changed)
            if ($answerLikes->getUser() === $this) {
                $answerLikes->setUser(null);
            }
        }

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(Profile $profile): self
    {
        $this->profile = $profile;

        // set the owning side of the relation if necessary
        if ($profile->getUser() !== $this) {
            $profile->setUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Conversation[]
     */
    public function getConversations(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(Conversation $conversation): self
    {
        if (!$this->conversations->contains($conversation)) {
            $this->conversations[] = $conversation;
            $conversation->addParticipant($this);
        }

        return $this;
    }

    public function removeConversation(Conversation $conversation): self
    {
        if ($this->conversations->contains($conversation)) {
            $this->conversations->removeElement($conversation);
            $conversation->removeParticipant($this);
        }

        return $this;
    }

}
