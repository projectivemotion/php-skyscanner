<?php
/**
 * Project: php-skyscanner
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

if($argc < 2)
    die("$argv[0] {API}");

// copied this from doctrine's bin/doctrine.php
$autoload_files = array( __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../../autoload.php');

foreach($autoload_files as $autoload_file)
{
    if(!file_exists($autoload_file)) continue;
    require_once $autoload_file;
}
// end autoloader finder

$Query  =   new \projectivemotion\phpSkyscanner\Request\LiveFlightQuery();
$Session    =   new \projectivemotion\phpSkyscanner\LiveFlights();

$Query->setApiKey($argv[1]);
$Query->setAdults(1);
$Query->setCountry('GR');
$Query->setLocale('en-GB');
$Query->setOriginPlace('skg');
$Query->setDestinationPlace('bud');
$Query->setIncludeCarriers('A3');
$Query->setLocationSchema('IATA');
$Query->setOutboundDate('2016-05-09');
$Query->setInboundDate('2016-05-11');
$Query->setCurrency('EUR');

try{
    $Session->Initialize($Query, 2);
    do {
        $data = $Session->Poll($Query);
    }while($data->isPending() && sleep(2) === 0);
}catch(\projectivemotion\phpSkyscanner\Exception $exception)
{
    die("Error: " . $exception->getMessage());
}



print_r($data);