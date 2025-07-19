<?php

namespace App\MiMascota\Users\Domain;

use App\MiMascota\Images\Domain\UserImage;
use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Locations\Domain\Location;
use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use App\MiMascota\Users\Domain\ValueObject\UserToken;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\MiMascota\Locations\Domain\UserLocation;

class User
{
    private Collection $journals;
    private UserToken $token;
    private UserImage $image;
    private UserLocation $location;


    private TimeStamp $timeStamp;
    private SoftDelete $softDelete;

 public function __construct(
     private readonly string       $id,
     private string                $name,
     private UserEmail              $email,
     private UserPassword $password,


 ) {
        $this->token = UserToken::generate()->reset();
        $this->journals = new ArrayCollection();
        $this->timeStamp = new TimeStamp();
        $this->softDelete = new SoftDelete();
 }
    /**
     * @param string $id
     * @param string $name
     * @param string $email
     * @param UserPassword $password
     * @return self
     */
    public static function create(string $id, string $name, UserEmail $email, UserPassword $password): self
    {
        return new self($id, $name, $email, $password);
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
        if (empty($password)) {
            return false;
        }
        $this->password = UserPassword::create($password);
        return true;
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
            $this->token = UserToken::generate();
        }
        return $this->token->getValue();
    }
    public function logout(): void
    {
        $this->token->reset();
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

