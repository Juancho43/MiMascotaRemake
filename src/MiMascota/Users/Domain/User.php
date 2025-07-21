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
        private readonly string $id,
        private UserName $name,
        private UserTelephone $telephone,
        private UserEmail $email,
        private UserPassword $password,
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
        return new self($id, $name, $telephone, $email, $password);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTelephone(): string
    {
        return $this->telephone->getValue();
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

    public function getTokens(): Collection
    {
        return $this->tokens;
    }


    /**
     * Original login method (backward compatibility)
     */
    public function login(string $password): string
    {
        try {
            $this->getPassword()->verify($password);
            if(!$this->getEmailObject()->isVerified()){
                throw new \Exception("Email not verified");
            }
            if ($this->tokens->count() > 0 && !$this->tokens->first()->isExpired()) {
                return $this->tokens->first()->getValue();
            }
            return $this->setToken();
        } catch (\Exception $exception){
            throw new \Exception("User login failed" . $exception->getMessage());
        }
    }

    /**
     * Login with IP and User Agent tracking - allows multiple tokens
     */
    public function loginWithDevice(string $password, string $ipAddress, string $userAgent): string
    {
        try {
            $this->getPassword()->verify($password);

            if (!$this->getEmailObject()->isVerified()) {
                throw new \Exception("Email not verified");
            }

            // Always create a new token for each login attempt
            // This allows multiple active sessions
            return $this->createTokenWithDevice($ipAddress, $userAgent);

        } catch (\Exception $exception) {
            throw new \Exception("User login failed: " . $exception->getMessage());
        }
    }

    /**
     * Original setToken method (backward compatibility)
     */
    public function setToken(): string
    {
        $newToken = UserToken::generate(Uuid::uuid4()->toString(), $this);
        $this->tokens->add($newToken);
        return $newToken->getValue();
    }

    /**
     * Create a new token with IP and User Agent
     */
    public function createTokenWithDevice(string $ipAddress, string $userAgent): string
    {
        $tokenId = Uuid::uuid4()->toString();
        $newToken = UserToken::generate($tokenId, $this, $ipAddress, $userAgent);
        $this->tokens->add($newToken);
        return $newToken->getValue();
    }

    /**
     * Find token by IP address
     */
    public function getTokenByIp(string $ipAddress): ?UserToken
    {
        foreach ($this->tokens as $token) {
            if ($token->getIpAddress() === $ipAddress && $token->checkExpired() !== null) {
                return $token;
            }
        }
        return null;
    }

    /**
     * Find token by User Agent
     */
    public function getTokenByUserAgent(string $userAgent): ?UserToken
    {
        foreach ($this->tokens as $token) {
            if ($token->getUserAgent() === $userAgent && $token->checkExpired() !== null) {
                return $token;
            }
        }
        return null;
    }

    /**
     * Find token by both IP and User Agent
     */
    public function findTokenByIpAndUserAgent(string $ipAddress, string $userAgent): ?UserToken
    {
        foreach ($this->tokens as $token) {
            if ($token->getIpAddress() === $ipAddress &&
                $token->getUserAgent() === $userAgent &&
                $token->checkExpired() !== null) {
                return $token;
            }
        }
        return null;
    }

    /**
     * Get all active tokens for a specific IP
     */
    public function getActiveTokensByIp(string $ipAddress): array
    {
        $activeTokens = [];
        foreach ($this->tokens as $token) {
            if ($token->getIpAddress() === $ipAddress && $token->checkExpired() !== null) {
                $activeTokens[] = $token;
            }
        }
        return $activeTokens;
    }

    /**
     * Get all active tokens for a specific User Agent
     */
    public function getActiveTokensByUserAgent(string $userAgent): array
    {
        $activeTokens = [];
        foreach ($this->tokens as $token) {
            if ($token->getUserAgent() === $userAgent && $token->checkExpired() !== null) {
                $activeTokens[] = $token;
            }
        }
        return $activeTokens;
    }

    /**
     * Logout from specific device (IP + User Agent)
     */
    public function logoutFromDevice(string $ipAddress, string $userAgent): bool
    {
        $token = $this->findTokenByIpAndUserAgent($ipAddress, $userAgent);
        if ($token) {
            $this->tokens->removeElement($token);
            return true;
        }
        return false;
    }

    /**
     * Logout from all devices
     */
    public function logoutFromAllDevices(): bool
    {
        $this->tokens->clear();
        return true;
    }

    /**
     * Legacy logout method - removes first token
     */
    public function logout(): bool
    {
        try {
            if ($this->tokens->isEmpty()) {
                throw new \Exception("No active tokens to logout");
            }

            $this->tokens->removeElement($this->tokens->first());
            return true;
        } catch (\Exception $exception) {
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

    public function getImage(): ?UserImage
    {
        return $this->image;
    }

    /**
     * Original verifyCodeAndLogin method (backward compatibility)
     */
    public function verifyCodeAndLogin(string $code): string
    {
        $this->email->verifyCode($code);
        return $this->setToken();
    }

    /**
     * Verify code and login with device tracking
     */
    public function verifyCodeAndLoginWithDevice(string $code, string $ipAddress, string $userAgent): string
    {
        $this->email->verifyCode($code);
        return $this->createTokenWithDevice($ipAddress, $userAgent);
    }
}
