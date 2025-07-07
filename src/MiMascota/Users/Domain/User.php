<?php

namespace App\MiMascota\Users\Domain;

use App\MiMascota\Images\Domain\Image;
use App\MiMascota\Images\Domain\ImageableInterface;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use App\MiMascota\Users\Domain\ValueObject\UserToken;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;

final class User implements UserInterface, ImageableInterface
{

    private Collection $journals;
    private UserToken $token;
    private Collection $images;
 public function __construct(
     private readonly string       $id,
     private string                $name,
     private string                $email,
     private readonly UserPassword $password,

 ) {
        $this->journals = new ArrayCollection();
        $this->images = new ArrayCollection();
 }
    /**
     * @param string $id
     * @param string $name
     * @param string $email
     * @param UserPassword $password
     * @return self
     */
    public static function create(string $id, string $name, string $email, UserPassword $password): self
    {
        return new self($id, $name, $email, $password);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): UserPassword
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        UserPassword::create($password);
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function rename(string $name): void
    {
        $this->name = $name;
    }

    public function addJournal(Journal $journal): void
    {
        $this->journals[] = $journal;
    }
    public function getJournals(): Collection
    {
        return $this->journals;
    }
    public function removeJournal(Journal $journal): void
    {
        $this->journals->removeElement($journal);
    }

    public function getToken(): ?string
    {
        return $this->token->getValue();
    }

    public function login(): void{
        $this->token = UserToken::generate();
    }

    public function logout(): void
    {
        $this->token->reset();
    }

    public function getRoles(): array
    {
        // TODO: Implement getRoles() method.
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->getName();
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setImageable($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            if ($image->getImageable() === $this) {
                $image->setImageable(null);
            }
        }

        return $this;
    }

    public function getImages(): Collection
    {
        return $this->images;
    }


    public function getImage(string $id): ?Image
    {
        foreach ($this->images as $image) {
            if ($image->getId() === $id) {
                return $image;
            }
        }

        return null;
    }
}

