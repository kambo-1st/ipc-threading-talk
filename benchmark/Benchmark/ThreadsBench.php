<?php

namespace Kambo\Benchmark;

use parallel\{Channel, Runtime, Future};

/**
 * @Iterations(5)
 * @Revs(5)
 * @Warmup(5)
 * @OutputTimeUnit("milliseconds", precision=5)
 */
class ThreadsBench
{
    const THREADS_COUNT = 5;

    public function benchRequest() {
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
        for ($i = 0; $i < self::THREADS_COUNT; $i++) {
            $runtimeList[] = new Runtime();
        }

        $futures = [];
        foreach ($runtimeList as $i => $runtime) {
            //echo "[run: $i]\n";
            $futures[] = $runtime->run($task, [$i]);
        }

        foreach ($futures as $i => $future) {
            //echo "[wait: $i]\n";
            $value = $future->value();
        }
    }
}