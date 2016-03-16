<?php
/**
 * Project: php-skyscanner
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\phpSkyscanner;


use GuzzleHttp\Client;
use projectivemotion\phpSkyscanner\Request\LiveFlightCreateSession;
use projectivemotion\phpSkyscanner\Request\LiveFlightQuery;
use projectivemotion\phpSkyscanner\Response\LiveFlightResponse;

class LiveFlights
{
    /**
     * @var SuperScraper
     */
//    protected $curlWrapper  =   null;

    protected $SessionURL   =   '';

    public function Initialize(LiveFlightQuery $query, $delay = 2)
    {
        $Location   =   LiveFlightCreateSession::GetSessionURL($query);

        sleep(max(1, $delay));

        $this->SessionURL   =   $Location;
    }

    /**
     * @param LiveFlightQuery $query
     * @return LiveFlightResponse
     * @throws Exception
     */
    public function Poll(LiveFlightQuery $query)
    {
        if(!$this->SessionURL)
        {
            throw new Exception("Initialize a session first.");
        }
        
        $http   =   new Client();
        $response   =   $http->request('GET', $this->SessionURL . '?' . http_build_query($query->asArray()),
                [
                    'allow_redirects' => false,
                    'headers' => ['Content-Type' => 'application/json'],
                    'synchronous'   =>true,
                ]);

        $code   =   $response->getStatusCode();

        // No Content, Not Modified => Wait..
        if($code == 204 || $code == 304)
        {
            return NULL;
        }

        $json   =   json_decode($response->getBody());

        if(!$json)
        {
            throw new Exception("Unable to parse JSON Response.");
        }

        return LiveFlightResponse::Create($json);
    }

    /**
     * Complete polling implementation.
     * This function is provided for convenience.      
     * You may decide to implement your own nonblocking polling algorithm.
     * I have written this function for use with zend_object cache
     * 
     * @param LiveFlightQuery $query
     * @param int $init_delay
     * @param int $poll_delay
     * @return LiveFlightResponse
     * @throws Exception
     */
    public function GetComplete(LiveFlightQuery $query, $init_delay = 2, $poll_delay = 2)
    {
        $this->Initialize($query, $init_delay);
        do {
            $response = $this->Poll($query);
        }while((!$response || $response->isPending()) && sleep($poll_delay) === 0);
        return $response;
    }
}