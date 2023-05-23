<?php

use parallel\Runtime;

$runtime = new Runtime(__DIR__ . '/test.inc');
// will throw an exception "Class "test" not found"
$runtime->run(static function (): void {
    $test = new test();
    $test->hello();
});
