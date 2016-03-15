<?php
/**
 * Project: php-skyscanner
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\phpSkyscanner;


use projectivemotion\PhpScraperTools\SuperScraper;
use projectivemotion\phpSkyscanner\Request\LiveFlightCreate;
use projectivemotion\phpSkyscanner\Request\LiveFlightQuery;
use projectivemotion\phpSkyscanner\Response\LiveFlightResponse;

class LiveFlights extends SuperScraper
{
    /**
     * @var SuperScraper
     */
//    protected $curlWrapper  =   null;

    protected $SessionURL   =   '';

    public function Initialize(LiveFlightQuery $query, $delay = 2)
    {
        $Location   =   LiveFlightCreate::GetSessionURL($query);

        sleep(max(1, $delay));

        $this->SessionURL   =   $Location;
    }

    public function Poll(LiveFlightQuery $query)
    {
        if(!$this->SessionURL)
        {
            throw new Exception("Initialize a session first.");
        }
        
        $http   =   new SuperScraper();
        $response   =   $http->getCurl($this->SessionURL . '?' . http_build_query($query->asArray()), NULL, TRUE);

        $json   =   json_decode($response);

        if(!$json)
        {
            throw new Exception("Unable to parse JSON Response.");
        }

        return LiveFlightResponse::Create($json);
    }
}