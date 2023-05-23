<?php

include __DIR__ . '/vendor/autoload.php';

use Spatie\Fork\Fork;


$fce = function ()  {
    $url = 'https://www.example.com';

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);

    $data = curl_exec($curl);

    curl_close($curl);
    return $data;
};

for ($i = 0; $i < 5; $i++) {
    $fces[] = $fce;
}

$results = Fork::new()
    ->run(
        ...$fces
    );

foreach ($results as $index=>$result) {
    echo "[end: $index]\n";
}
