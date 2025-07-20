<?php

namespace App\MiMascota\Users\Domain;

use App\MiMascota\Images\Domain\UserImage;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Locations\Domain\UserLocation;
use App\MiMascota\Posts\Domain\Post;
use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserName;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use App\MiMascota\Users\Domain\ValueObject\UserTelephone;
use App\MiMascota\Users\Domain\ValueObject\UserToken;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;

class User
{
    private Collection $posts;
    private Collection $journals;
    private Collection $tokens;
    private Collection $preferences;


    private UserImage $image;
    private UserLocation $location;

    private TimeStamp $timeStamp;
    private SoftDelete $softDelete;

 public function __construct(
    private readonly string        $id,
    private UserName               $name,
    private UserTelephone          $telephone,
    private UserEmail              $email,
    private UserPassword           $password,


 ) {
        $this->posts = new ArrayCollection();
        $this->preferences = new ArrayCollection();
        $this->tokens = new ArrayCollection();
        $this->journals = new ArrayCollection();
        $this->timeStamp = new TimeStamp();
        $this->softDelete = new SoftDelete();
 }

    public static function create(string $id, UserName $name, UserTelephone $telephone, UserEmail $email, UserPassword $password): self
    {
        return new self($id, $name, $telephone ,$email, $password);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email->getValue();
    }
    public function getValidationCode(): string
    {
        return $this->email->getCode();
    }
    public function getEmailObject(): UserEmail
    {
        return $this->email;
    }


    public function getPassword(): UserPassword
    {
        return $this->password;
    }

    public function changePassword(string $password): bool
    {
        $this->password = UserPassword::create($password);
        $this->tokens->clear();
        return true;
    }


    public function getName(): string
    {
        return $this->name->getValue();
    }

    public function rename(string $name): void
    {
        $this->name = UserName::create($name);
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
    public function addPost(Post $post): void
    {
        $this->posts[] = $post;
    }
    public function getPosts(): Collection
    {
        return $this->posts;
    }
    public function removePost(Post $post): void
    {
        $this->posts->removeElement($post);
    }
    public function getToken(): ?array
    {
        return $this->tokens->getValues();
    }


    public function login(string $password): string
    {
        try {
            $this->getPassword()->verify($password);
            if(!$this->getEmailObject()->isVerified()){
                throw new \Exception("Email not verified");
            }

            return $this->setToken();
        } catch (\Exception $exception){
            throw new \Exception("User login failed" . $exception);
        }
    }

    public function setToken() : string
    {
        if ($this->getToken() == null) {
            $newToken = UserToken::generate(Uuid::uuid4()->toString(), $this);
            $this->tokens->add($newToken);
        }
        return $newToken->getValue();
    }
    public function logout(): bool
    {
        try {
            if($this->getToken() == null) {
                throw new \Exception("User logout failed");
            }

            $this->tokens->removeElement($this->getToken());
            return true;
        }catch (\Exception $exception){
            throw $exception;
        }


    }


    public function getUserLocation(): UserLocation
    {
        return $this->location;
    }

    public function setLocation(UserLocation $location): void
    {
        $this->location = $location;
    }

    public function setImage(UserImage $image): void
    {
        $this->image = $image;
    }
    public function getImage() : ?UserImage
    {
        return $this->image;
    }
    public function verifyCodeAndLogin(string $code) : bool
    {
        $response = $this->email->verifyCode($code);
        if ($response) {
            $this->setToken();
        }
        return $response;
    }

}

