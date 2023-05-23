<?php

include __DIR__ . '/vendor/autoload.php';

use Spatie\Async\Pool;

$pool = Pool::create();

foreach (array_fill(0, 5, 'https://www.example.com') as $index => $thing) {
    $pool->add(function () use ($index, $thing) {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $thing);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);

        $data = curl_exec($curl);

        curl_close($curl);

        return [$data, $index];
        // Do a thing
    })->then(function ($output) {
        [, $index] = $output;
        echo "[end: $index]\n";
    })->catch(function (Throwable $exception) {
        throw $exception;
    });
}

$pool->wait();