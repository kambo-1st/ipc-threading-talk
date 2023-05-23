<?php

use parallel\{Channel, Runtime};

const THREADS_COUNT = 5;

$ch = new Channel();
$task = static function (int $i, Channel $ch): void {
    echo "[waiting: $i]\n";
    $ch->send('Message from: '.$i."\n");
    echo "[exit: $i]\n";
};

$runtimeList = [];
for ($i = 0; $i < THREADS_COUNT; $i++) {
    $runtimeList[] = new Runtime();
}

foreach ($runtimeList as $i => $runtime) {
    echo "[run: $i]\n";
    $runtime->run($task, [$i, $ch]);
}

for ($i = 0; $i < THREADS_COUNT; $i++) {
    echo $ch->recv();
}
$ch->close();
