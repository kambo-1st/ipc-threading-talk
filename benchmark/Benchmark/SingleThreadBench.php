<?php

namespace Kambo\Benchmark;

/**
 * @Iterations(5)
 * @Revs(5)
 * @Warmup(5)
 * @OutputTimeUnit("milliseconds", precision=5)
 */
class SingleThreadBench
{
    public function benchRequest() {

        foreach (array_fill(0, 5, 'https://www.example.com') as $url) {
                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HEADER, false);

                $data = curl_exec($curl);

                curl_close($curl);
        }
    }
}
