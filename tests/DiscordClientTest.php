<?php

use Discord\DiscordClient;
use Discord\Embed;
use PHPUnit\Framework\TestCase;

/**
 * User: Raphael Pelissier
 * Date: 06-07-20
 * Time: 11:11
 */
class DiscordClientTest extends TestCase
{
    /**
     * @var string
     */
    private $testWebhook = 'https://discordapp.com/api/webhooks/729627214638874654/OW1jUAvxQVFChSxzFEFY8JspYASINp_yIfeKuyBWfBAEJmkPoTjvvojDqsWf3blKYPDE';

    public function testCanConstructDiscordClientFromValidWebhook()
    {
        $client = new DiscordClient($this->testWebhook);

        $this->assertInstanceOf(
            DiscordClient::class,
            $client
        );

        return $client;
    }

    public function testCannotConstructDiscordClientFromValidWebhook()
    {
        $this->expectException(InvalidArgumentException::class);

        new DiscordClient('invalid webhook url');
    }

    /**
     * @depends testCanConstructDiscordClientFromValidWebhook
     * @param DiscordClient $client
     */
    public function testCanSendMessage(DiscordClient $client)
    {
        $response = $client->setMessage('@testCanSendMessage')->send();
        $this->assertEquals('204', $response->getStatusCode());
        $this->assertEquals(null, $client->getMessage());
    }

    public function testCanMakeValidEmbed()
    {
        $embed = new Embed();
        $embed->setTitle('@test')->setDescription('@testCanMakeValidEmbed')->setColor('#0000ff');

        $this->assertEquals('@test', $embed->getTitle());
        $this->assertEquals('@testCanMakeValidEmbed', $embed->getDescription());
        $this->assertEquals('#0000ff', $embed->getColor());

        $this->assertInstanceOf(
            Embed::class,
            $embed
        );
        return $embed;
    }

    /**
     * @depends testCanConstructDiscordClientFromValidWebhook
     * @depends testCanMakeValidEmbed
     * @param DiscordClient $client
     * @param Embed $embed
     */
    public function testCanSendEmbed(DiscordClient $client, Embed $embed)
    {
        $response = $client->addEmbed($embed)->send();
        $this->assertEquals('204', $response->getStatusCode());
        $this->assertEmpty($client->getEmbeds());
    }

    /**
     * @depends testCanConstructDiscordClientFromValidWebhook
     * @depends testCanMakeValidEmbed
     * @param DiscordClient $client
     * @param Embed $embed
     */
    public function testCanSendMultipleEmbeds(DiscordClient $client, Embed $embed)
    {
        $response = $client->addEmbed($embed)->addEmbed($embed)->send();
        $this->assertEquals('204', $response->getStatusCode());
        $this->assertEmpty($client->getEmbeds());
    }


}
