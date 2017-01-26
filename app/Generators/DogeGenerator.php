<?php

declare(strict_types=1);

namespace App\Generators;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

/**
 * This is the doge meme generator class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class DogeGenerator implements GeneratorInterface
{
    /**
     * The guzzle client.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * The output path.
     *
     * @var string
     */
    protected $output;

    /**
     * Create a new doge meme generator instance.
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string                      $output
     *
     * @return void
     */
    public function __construct(ClientInterface $client, string $output)
    {
        $this->client = $client;
        $this->output = $output;
    }

    /**
     * Generate the image.
     *
     * @param string $text
     *
     * @throws \App\Generators\ExceptionInterface
     *
     * @return string
     */
    public function generate(string $text)
    {
        $name = str_random(16);

        if ($text === GeneratorInterface::NUMBER_THEORY) {
            $text = 'number theory is prime shit with euler and gauss';
        }

        $this->call($text, "{$this->output}/{$name}.jpg");

        return $name;
    }

    /**
     * Make the generation HTTP call.
     *
     * @param string $text
     * @param string $output
     *
     * @throws \App\Generators\GenerationException
     *
     * @return void
     */
    protected function call(string $text, string $output)
    {
        $query = ['inptext' => $text, 'outdir' => $output, 'maxphrases' => 6];

        try {
            $this->client->get('makememe', ['query' => $query]);
        } catch (GuzzleException $e) {
            throw new GenerationException((string) $e->getMessage(), $e->getCode(), $e);
        }
    }
}
