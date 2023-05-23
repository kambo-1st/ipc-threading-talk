<?php declare(strict_types=1);

include __DIR__ . '/vendor/autoload.php';

use Amp\Future;
use Amp\Http\Client\HttpClientBuilder;
use Amp\Http\Client\HttpException;
use Amp\Http\Client\Request;
use function Amp\async;

$uris = [
    "https://google.com/",
    "https://github.com/",
    "https://stackoverflow.com/",
];

// Instantiate the HTTP client
$client = HttpClientBuilder::buildDefault();

$requestHandler = static function (string $uri) use ($client): string {
    $response = $client->request(new Request($uri));
    return $response->getBody()->buffer();
};

try {
    $futures = [];

    foreach ($uris as $uri) {
        $futures[$uri] = async(fn () => $requestHandler($uri));
    }

    $bodies = Future\await($futures);

    foreach ($bodies as $uri => $body) {
        print $uri . " - " . strlen($body) . " bytes" . PHP_EOL;
    }
} catch (HttpException $error) {
    // If something goes wrong Amp will throw the exception where the promise was yielded.
    // The HttpClient::request() method itself will never throw directly, but returns a promise.
    echo $error;
}
