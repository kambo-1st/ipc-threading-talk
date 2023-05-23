<?php

use parallel\{Channel, Runtime};

$foo = new stdClass();

$task = static function ($foo): void {
    echo $foo->bar."\n";
    $foo->qux = 'quux';
};

$foo->bar = 'baz';
$runtime = new Runtime();
$runtime->run($task, [$foo]);

echo $foo->qux."\n";
