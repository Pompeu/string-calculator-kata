<?php
// coverage-checker.php

$args = check_args($argv);

$inputFile  = $args['$inputFile'];
$percentage = $args['$percentage'];

if (!file_exists($inputFile)) {
    throw new InvalidArgumentException('Invalid input file provided');
}

if (!$percentage) {
    throw new InvalidArgumentException('An integer checked percentage must be given as second parameter');
}

$xml             = new SimpleXMLElement(file_get_contents($inputFile));
$metrics         = $xml->xpath('//metrics');
$totalElements   = 0;
$checkedElements = 0;

foreach ($metrics as $metric) {
    $totalElements   += (int) $metric['elements'];
    $checkedElements += (int) $metric['coveredelements'];
}

$coverage = ($checkedElements / $totalElements) * 100;

if ($coverage < $percentage) {
    echo 'Code coverage is ' . $coverage . '%, which is below the accepted ' . $percentage . '%' . PHP_EOL;
    exit(1);
}

echo 'Code coverage is ' . $coverage . '% - OK!' . PHP_EOL;

function check_args(...$args)
{
    if (isset($args) && count($args) === 3) {
        $percentage = min(100,max(0, (int) $args[2]));
        return array(
            '$inputFile' => $args[1],
            '$percentage' => $percentage 
        );
    }

    return array(
        '$inputFile' => 'cover.xml', 
        '$percentage' =>  85
    );
}
