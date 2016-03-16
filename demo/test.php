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

$CarrierINFO    =   \projectivemotion\phpSkyscanner\Schema\Carrier::Create([
    'Id' => 819,
    'Code' => 'A3',
    'Name' => 'Aegan Airlines',
    'DisplayCode' => 'A3'
]);

$AgentINFO  =   \projectivemotion\phpSkyscanner\Schema\Agent::Create([
    'Id'    =>  4070002,
    'Name'  =>  'travelplan.gr'
]);

$Query->setApiKey($argv[1]);
$Query->setAdults(1);
$Query->setCountry('GR');
$Query->setLocale('el-GR');
$Query->setOriginPlace('skg');
$Query->setDestinationPlace('ath');
$Query->setIncludeCarriers($CarrierINFO->Code);
$Query->setCarrierschema('IATA');
$Query->setLocationSchema('IATA');
$Query->setOutboundDate('2016-05-09');
$Query->setInboundDate('2016-05-11');
$Query->setCurrency('EUR');
$Query->setGroupPricing(false);

$cachestorage   =   \Zend\Cache\StorageFactory::factory(
    [
        'adapter'   =>  [
            'name'  =>  'filesystem',
            'options'   =>  [
                'cache_dir' =>  '/tmp/cache',
                'ttl'   =>  60*60*24,
//                            'umask' =>  0022,
                'filePermission'    =>  0666,
                'dirPermission'     =>  0777
            ]
        ],
        'plugins'   =>  ['serializer']
    ]
);

/**
 * @var \projectivemotion\phpSkyscanner\LiveFlights
 */
$object_cache   =   \Zend\Cache\PatternFactory::factory('object', [
    'object' => $Session,
    'storage'   =>  $cachestorage,
    'cache_output'  => false
]);

try{
    /**
     * @var $results \projectivemotion\phpSkyscanner\Response\LiveFlightResponse
     */
//    $results   =   $object_cache->GetComplete($Query, 2, 2);
    $results   =   $Session->GetComplete($Query, 2, 2);

    foreach($results->generateItineraries() as $curItinerary)
    {
        $IsOutboundDirect   =   $curItinerary->IsOutboundDirect();
        $IsInbundDirect   =   $curItinerary->IsInboundDirect();

        if(!$IsInbundDirect || !$IsInbundDirect) continue;

        if(!$curItinerary->IsCarrierID($CarrierINFO->Id))
            continue;   // not carrier we need.
        
        $AgentPrice =   $curItinerary->getAgentPrice($AgentINFO->Id);

        if(!$AgentPrice)
        {
            printf("Agent Not Found\n");
            continue;
        }
        $outFlights =   $curItinerary->getFlightNumbers('Outbound');
        $inFlights =   $curItinerary->getFlightNumbers('Inbound');

        printf("Airline: %s Out: %s, In: %s Total: %s Url: %s\n", $CarrierINFO->Name, $outFlights[0]->FlightNumber, $inFlights[0]->FlightNumber, $AgentPrice->Price, $AgentPrice->DeeplinkUrl);
    }

}catch(\projectivemotion\phpSkyscanner\Exception $exception)
{
    die("Error: " . $exception->getMessage());
}



//print_r($results);