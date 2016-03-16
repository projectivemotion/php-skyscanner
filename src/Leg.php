<?php
/**
 * Project: php-skyscanner
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\phpSkyscanner;


use projectivemotion\phpSkyscanner\Response\LiveFlightResponse;
use projectivemotion\phpSkyscanner\Schema\FlightNumber;

class Leg extends \ArrayObject
{
    /**
     * @var LiveFlightResponse
     */
    protected $Response =   NULL;

    public function __construct($input)
    {
        parent::__construct($input, \ArrayObject::ARRAY_AS_PROPS);
    }

    /**
     * @param $LegData
     * @param LiveFlightResponse $flightResponse
     * @return static
     */
    public static function Create($LegData, LiveFlightResponse $flightResponse)
    {
        $self   =   new static((array)$LegData);
        $self->Response =   $flightResponse;
        return $self;
    }

    public function IsDirectFlight()
    {
        return count($this->Stops) == 0;
    }

    /**
     * @return FlightNumber[]
     */
    public function getFlightNumbers()
    {
        $flights    =   [];

        foreach($this->FlightNumbers as $flightNumber)
        {
            $flights[]  =   FlightNumber::Create($flightNumber);
        }

        return $flights;
    }
}