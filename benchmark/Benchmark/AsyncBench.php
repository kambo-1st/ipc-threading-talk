<?php

namespace Kambo\Benchmark;

use Amp\Future;
use Amp\Http\Client\HttpClientBuilder;
use Amp\Http\Client\HttpException;
use Amp\Http\Client\Request;
use function Amp\async;

/**
 * @Iterations(5)
 * @Revs(5)
 * @Warmup(5)
 * @OutputTimeUnit("milliseconds", precision=5)
 */
class AsyncBench
{
    public function benchRequest() {
        $client = HttpClientBuilder::buildDefault();

        $requestHandler = static function (string $uri) use ($client): string {
            $response = $client->request(new Request($uri));
            return $response->getBody()->buffer();
        };

        $futures = [];

        $uris = array_fill(0, 5, 'https://www.example.com');

        foreach ($uris as $uri) {
            $futures[] = async(fn () => $requestHandler($uri));
        }

        $bodies = Future\await($futures);

        foreach ($bodies as $body) {
            $value = $body;
        }

    }
}