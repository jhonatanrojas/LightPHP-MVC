<?php

use PHPUnit\Framework\TestCase;
use services\SocialMediaPost;
use Facebook\Facebook;
use Abraham\TwitterOAuth\TwitterOAuth;
use Dotenv\Dotenv;
class SocialMediaPostTest extends TestCase
{
    private $socialMediaPost;
    private $facebook;
    private $twitter;

    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../../../');
        $dotenv->load();
        $this->facebook = $this->createMock(Facebook::class);
        $this->twitter = $this->createMock(TwitterOAuth::class);

        $this->socialMediaPost = new SocialMediaPost($this->facebook, $this->twitter);
    }

    public function testPostToFacebook()
    {
        // Configura el mock de Facebook para que devuelva un resultado específico cuando se llama a post
        $this->facebook->method('post')->willReturn([
            'result' => true, 
            'message' => 'Publicado correctamente en Facebook', 
            'error' => ''
        ]);

        $result = $this->socialMediaPost->postToFacebook('Test message', [], [], 'test_access_token');

        $this->assertTrue($result['result']);
        $this->assertEquals('Publicado correctamente en Facebook', $result['message']);
        $this->assertEquals('', $result['error']);
    }

    public function testPostToTwitter()
    {
        // Configura el mock de Twitter para que devuelva un resultado específico cuando se llama a post
        $this->twitter->method('post')->willReturn((object) [
            'errors' => null
        ]);

        $this->twitter->method('getLastHttpCode')->willReturn(200);

        $result = $this->socialMediaPost->postToTwitter('Test message', [], [], 'test_access_token', 'test_access_token_secret');

        $this->assertTrue($result['result']);
        $this->assertEquals('Tweet publicado correctamente', $result['message']);
        $this->assertEquals('', $result['error']);
    }

    
}
