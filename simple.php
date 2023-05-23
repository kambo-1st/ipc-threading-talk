<?php

use parallel\{Channel, Runtime};

const THREADS_COUNT = 5;

$task = static function (int $i): void {
    echo "[enter: $i]\n";
    echo "work";
    echo "[exit: $i]\n";
};

$runtimeList = [];
for ($i = 0; $i < THREADS_COUNT; $i++) {
    $runtimeList[] = new Runtime();
}

foreach ($runtimeList as $i => $runtime) {
    echo "[run: $i]\n";
    $runtime->run($task, [$i]);
}
