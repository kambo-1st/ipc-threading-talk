<?php

use parallel\{Channel, Runtime};

const THREADS_COUNT = 5;

$ch = new Channel(8);
$task = static function (int $i, Channel $ch): void {
    $ch->send('Message from: '.$i."\n");
};

$runtimeList = [];
for ($i = 0; $i < THREADS_COUNT; $i++) {
    $runtimeList[] = new Runtime();
}

foreach ($runtimeList as $i => $runtime) {
    $runtime->run($task, [$i, $ch]);
}


$queue = '';
for ($i = 0; $i < THREADS_COUNT; $i++) {
    $queue .= $ch->recv();
}
$ch->close();

echo $queue;
