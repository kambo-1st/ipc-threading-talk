<?php

use parallel\{Channel, Runtime, Future, Events,Events\Event};

const THREADS_COUNT = 50;

$task = static function (int $i=0) {
    $url = 'https://www.example.com';

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);

    $data = curl_exec($curl);

    curl_close($curl);
    //echo "[exit: $i]\n";
    return $data;
};

$runtimeList = [];
for ($i = 0; $i < THREADS_COUNT; $i++) {
    $runtimeList[] = new Runtime();
}

$events = new Events();
$events->setBlocking(true);

foreach ($runtimeList as $i => $runtime) {
    echo "[run: $i]\n";
    $future = $runtime->run($task, [$i]);
    $events->addFuture('http'.$i,$future);
}

do {
    $event = $events->poll();
    if ($event && str_contains($event->source, 'http')) {
        echo $event->type."\n";
        echo $event->source."\n";
        echo $event->value."\n";
    }
} while ($event);
