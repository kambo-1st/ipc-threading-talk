<?php

use parallel\{Channel, Runtime, Future};

$start = microtime(true);
const THREADS_COUNT = 5;

$task = static function (int $i=0) {
    $url = 'https://www.example.com';

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);

    $data = curl_exec($curl);

    curl_close($curl);
    echo "[exit: $i]\n";
    return $data;
};

$runtimeList = [];
for ($i = 0; $i < THREADS_COUNT; $i++) {
    $runtimeList[] = new Runtime();
}

$futures = [];
foreach ($runtimeList as $i => $runtime) {
    echo "[run: $i]\n";
    $futures[] = $runtime->run($task, [$i]);
}

foreach ($futures as $i => $future) {
    echo "[wait: $i]\n";
    echo substr($future->value(),0,10).'...'."\n";
}
