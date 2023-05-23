<?php

use parallel\Runtime;

class test {
    public function hello() {
        echo "Hello World!\n";
    }
}

$runtime = new Runtime();
// will throw an exception "Class "test" not found"
$runtime->run(static function (): void {
    $test = new test();
    $test->hello();
});
