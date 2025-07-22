<?php

namespace App\Tests\MiMascota\Users\Domain;

use App\MiMascota\Journals\Domain\Journal;
use App\MiMascota\Users\Domain\User;
use App\MiMascota\Users\Domain\ValueObject\UserEmail;
use App\MiMascota\Users\Domain\ValueObject\UserName;
use App\MiMascota\Users\Domain\ValueObject\UserPassword;
use App\MiMascota\Users\Domain\ValueObject\UserTelephone;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserTokenWithDeviceTest extends TestCase
{
    private User $user;
    private string $validPassword = 'Test123!';
    private string $ipAddress1 = '192.168.1.100';
    private string $ipAddress2 = '10.0.0.1';
    private string $userAgent1 = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36';
    private string $userAgent2 = 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X)';

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user with verified email
        $email = UserEmail::create('test@example.com');
        $email->verifyCode($email->getCode()); // Verify the email

        $this->user = User::create(
            Uuid::uuid4()->toString(),
            UserName::create('Test User'),
            UserTelephone::create('+1234567890'),
            $email,
            UserPassword::create($this->validPassword)
        );
    }

    /**
     * Test 1: Can login with IP and User Agent
     */
    public function testCanLoginWithIPAndUserAgent(): void
    {
        // Test login with device information
        $token = $this->user->loginWithDevice($this->validPassword, $this->ipAddress1, $this->userAgent1);

        // Verify token was created
        $this->assertNotEmpty($token);
        $this->assertIsString($token);

        // Verify token is in the user's token collection
        $tokens = $this->user->getTokens();
        $this->assertCount(1, $tokens);

        // Get the created token and verify its properties
        $createdToken = $tokens->first();
        $this->assertEquals($this->ipAddress1, $createdToken->getIpAddress());
        $this->assertEquals($this->userAgent1, $createdToken->getUserAgent());
        $this->assertEquals($token, $createdToken->getValue());
    }

    /**
     * Test 2: Can have multiple tokens
     */
    public function testCanHaveMultipleTokens(): void
    {
        // Login from first device
        $token1 = $this->user->loginWithDevice($this->validPassword, $this->ipAddress1, $this->userAgent1);

        // Login from second device (different IP)
        $token2 = $this->user->loginWithDevice($this->validPassword, $this->ipAddress2, $this->userAgent1);

        // Login from third device (different User Agent)
        $token3 = $this->user->loginWithDevice($this->validPassword, $this->ipAddress1, $this->userAgent2);

        // Verify all tokens are different
        $this->assertNotEquals($token1, $token2);
        $this->assertNotEquals($token1, $token3);
        $this->assertNotEquals($token2, $token3);

        // Verify user has multiple tokens
        $tokens = $this->user->getTokens();
        $this->assertCount(3, $tokens);

        // Verify each token has correct device information
        $tokenArray = $tokens->toArray();

        $this->assertEquals($this->ipAddress1, $tokenArray[0]->getIpAddress());
        $this->assertEquals($this->userAgent1, $tokenArray[0]->getUserAgent());

        $this->assertEquals($this->ipAddress2, $tokenArray[1]->getIpAddress());
        $this->assertEquals($this->userAgent1, $tokenArray[1]->getUserAgent());

        $this->assertEquals($this->ipAddress1, $tokenArray[2]->getIpAddress());
        $this->assertEquals($this->userAgent2, $tokenArray[2]->getUserAgent());
    }

    /**
     * Test 3a: Get Token by IP
     */
    public function testGetTokenByIP(): void
    {
        // Create tokens from different IPs
        $token1 = $this->user->loginWithDevice($this->validPassword, $this->ipAddress1, $this->userAgent1);
        $token2 = $this->user->loginWithDevice($this->validPassword, $this->ipAddress2, $this->userAgent2);

        // Test finding token by IP
        $foundToken1 = $this->user->getTokenByIp($this->ipAddress1);
        $foundToken2 = $this->user->getTokenByIp($this->ipAddress2);

        // Verify correct tokens are found
        $this->assertNotNull($foundToken1);
        $this->assertNotNull($foundToken2);
        $this->assertEquals($token1, $foundToken1->getValue());
        $this->assertEquals($token2, $foundToken2->getValue());

        // Test with non-existent IP
        $nonExistentToken = $this->user->getTokenByIp('999.999.999.999');
        $this->assertNull($nonExistentToken);
    }

    /**
     * Test 3b: Get Token by User Agent
     */
    public function testGetTokenByUserAgent(): void
    {
        // Create tokens with different user agents
        $token1 = $this->user->loginWithDevice($this->validPassword, $this->ipAddress1, $this->userAgent1);
        $token2 = $this->user->loginWithDevice($this->validPassword, $this->ipAddress2, $this->userAgent2);

        // Test finding token by User Agent
        $foundToken1 = $this->user->getTokenByUserAgent($this->userAgent1);
        $foundToken2 = $this->user->getTokenByUserAgent($this->userAgent2);

        $this->assertNotNull($foundToken1);
        $this->assertNotNull($foundToken2);
        $this->assertEquals($token1, $foundToken1->getValue());
        $this->assertEquals($token2, $foundToken2->getValue());

        // Test with non-existent User Agent
        $nonExistentToken = $this->user->getTokenByUserAgent('Non-existent-Browser/1.0');
        $this->assertNull($nonExistentToken);
    }

    /**
     * Test 3c: Get Token by both IP and User Agent
     */
    public function testGetTokenByIPAndUserAgent(): void
    {
        // Create tokens with different combinations
        $token1 = $this->user->loginWithDevice($this->validPassword, $this->ipAddress1, $this->userAgent1);
        $token2 = $this->user->loginWithDevice($this->validPassword, $this->ipAddress1, $this->userAgent2); // Same IP, different UA
        $token3 = $this->user->loginWithDevice($this->validPassword, $this->ipAddress2, $this->userAgent1); // Different IP, same UA

        // Test finding tokens by specific IP and User Agent combinations
        $foundToken1 = $this->user->findTokenByIpAndUserAgent($this->ipAddress1, $this->userAgent1);
        $foundToken2 = $this->user->findTokenByIpAndUserAgent($this->ipAddress1, $this->userAgent2);
        $foundToken3 = $this->user->findTokenByIpAndUserAgent($this->ipAddress2, $this->userAgent1);

        // Verify correct tokens are found
        $this->assertNotNull($foundToken1);
        $this->assertNotNull($foundToken2);
        $this->assertNotNull($foundToken3);
        $this->assertEquals($token1, $foundToken1->getValue());
        $this->assertEquals($token2, $foundToken2->getValue());
        $this->assertEquals($token3, $foundToken3->getValue());

        // Test with non-existent combination
        $nonExistentToken = $this->user->findTokenByIpAndUserAgent($this->ipAddress2, $this->userAgent2);
        $this->assertNull($nonExistentToken);
    }

    /**
     * Test multiple active tokens for same IP
     */
    public function testGetActiveTokensByIP(): void
    {
        // Create multiple tokens for same IP with different user agents
        $token1 = $this->user->loginWithDevice($this->validPassword, $this->ipAddress1, $this->userAgent1);
        $token2 = $this->user->loginWithDevice($this->validPassword, $this->ipAddress1, $this->userAgent2);
        $token3 = $this->user->loginWithDevice($this->validPassword, $this->ipAddress2, $this->userAgent1); // Different IP

        // Get all active tokens for specific IP
        $tokensForIP1 = $this->user->getActiveTokensByIp($this->ipAddress1);
        $tokensForIP2 = $this->user->getActiveTokensByIp($this->ipAddress2);

        // Verify correct number of tokens
        $this->assertCount(2, $tokensForIP1); // Two tokens for IP1
        $this->assertCount(1, $tokensForIP2); // One token for IP2

        // Verify token values
        $tokenValues1 = array_map(fn($token) => $token->getValue(), $tokensForIP1);
        $this->assertContains($token1, $tokenValues1);
        $this->assertContains($token2, $tokenValues1);

        $this->assertEquals($token3, $tokensForIP2[0]->getValue());
    }

    /**
     * Test multiple active tokens for same User Agent
     */
    public function testGetActiveTokensByUserAgent(): void
    {
        // Create multiple tokens for same User Agent with different IPs
        $token1 = $this->user->loginWithDevice($this->validPassword, $this->ipAddress1, $this->userAgent1);
        $token2 = $this->user->loginWithDevice($this->validPassword, $this->ipAddress2, $this->userAgent1);
        $token3 = $this->user->loginWithDevice($this->validPassword, $this->ipAddress1, $this->userAgent2); // Different UA

        // Get all active tokens for specific User Agent
        $tokensForUA1 = $this->user->getActiveTokensByUserAgent($this->userAgent1);
        $tokensForUA2 = $this->user->getActiveTokensByUserAgent($this->userAgent2);

        // Verify correct number of tokens
        $this->assertCount(2, $tokensForUA1); // Two tokens for UA1
        $this->assertCount(1, $tokensForUA2); // One token for UA2

        // Verify token values
        $tokenValues1 = array_map(fn($token) => $token->getValue(), $tokensForUA1);
        $this->assertContains($token1, $tokenValues1);
        $this->assertContains($token2, $tokenValues1);

        $this->assertEquals($token3, $tokensForUA2[0]->getValue());
    }


    /**
     * Test logout from specific device
     */
    public function testLogoutFromSpecificDevice(): void
    {
        // Create multiple tokens
        $token1 = $this->user->loginWithDevice($this->validPassword, $this->ipAddress1, $this->userAgent1);
        $token2 = $this->user->loginWithDevice($this->validPassword, $this->ipAddress2, $this->userAgent2);

        $this->assertCount(2, $this->user->getTokens());

        // Logout from specific device
        $loggedOut = $this->user->logoutFromDevice($this->ipAddress1, $this->userAgent1);
        $this->assertTrue($loggedOut);

        // Verify only one token remains
        $this->assertCount(1, $this->user->getTokens());

        // Verify the correct token was removed
        $remainingToken = $this->user->getTokens()->first();
        $this->assertEquals($token2, $remainingToken->getValue());
        $this->assertEquals($this->ipAddress2, $remainingToken->getIpAddress());
        $this->assertEquals($this->userAgent2, $remainingToken->getUserAgent());
    }

    /**
     * Test error cases
     */
    public function testErrorCases(): void
    {
        // Test login with wrong password
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('User login failed');

        $this->user->loginWithDevice('wrongpassword', $this->ipAddress1, $this->userAgent1);
    }

    public function testUserCanLogoutOfAllDevices(): void
    {
        $token1 = $this->user->loginWithDevice($this->validPassword, $this->ipAddress1, $this->userAgent1);
        $this->assertTrue($this->user->logoutFromAllDevices());
        $this->assertCount(0,$this->user->getTokens());
    }



}
