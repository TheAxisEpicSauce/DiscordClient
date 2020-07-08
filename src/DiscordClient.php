<?php
/**
 * User: Raphael Pelissier
 * Date: 06-07-20
 * Time: 11:04
 */

namespace Discord;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class DiscordClient
{
    /**
     * @var string
     */
    private $webhook;
    /**
     * @var Client
     */
    private $client;
    /**
     * @var string
     */
    private $message;
    /**
     * @var array|Embed[]
     */
    private $embeds;

    /**
     * Discord constructor.
     * @param string $webhook
     */
    public function __construct(string $webhook)
    {
        if (substr($webhook, 0, 36) !== 'https://discordapp.com/api/webhooks/') throw new \InvalidArgumentException();

        $this->webhook = $webhook;
        $this->embeds = [];

        $this->client = new Client([
            'base_uri' => $this->webhook
        ]);
    }

    public function send()
    {
        $request = new Request('POST', '', [
            'content-type' => 'application/json'
        ], $this->prepareBody());

        return $this->client->send($request);
    }

    private function prepareBody()
    {
        $body = [];
        if ($this->message !== null) {
            $body['content'] = $this->message;
            $this->message = null;
        }
        foreach ($this->embeds as $embed) {
            $body['embeds'][] = $embed->toArray();
        }
        $this->embeds = [];

        return json_encode($body);
    }

    //-------------------------------------------
    // Getters/Setters
    //-------------------------------------------
    /**
     * @return string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return DiscordClient
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param Embed $embed
     * @return DiscordClient
     */
    public function addEmbed(Embed $embed): self
    {
        $this->embeds[] = $embed;
        return $this;
    }

    /**
     * @return array|Embed[]
     */
    public function getEmbeds(): array
    {
        return $this->embeds;
    }
}
