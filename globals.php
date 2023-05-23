<?php

use parallel\{Channel, Runtime};

$task = static function (): void {
    echo $GLOBALS['foo']."\n";
    $GLOBALS['qux'] = 'quux';
};

$GLOBALS['foo'] = 'bar';
$runtime = new Runtime();
$runtime->run($task);

var_dump($GLOBALS['qux']);
