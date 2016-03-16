<?php
/**
 * Project: php-skyscanner
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\phpSkyscanner\Response;


use projectivemotion\phpSkyscanner\Itinerary;
use projectivemotion\phpSkyscanner\Leg;

class LiveFlightResponse extends \ArrayObject
{
    public function __construct($input)
    {
        parent::__construct($input, \ArrayObject::ARRAY_AS_PROPS);
    }

    public function isComplete()
    {
        return $this->Status == 'UpdatesComplete';
    }

    public function isPending()
    {
        return $this->Status == 'UpdatesPending';
    }

    /**
     * @param $json_response
     * @return static
     */
    public static function Create($json_response)
    {
        $self   =   new static((array)$json_response);
        return $self;
    }

    /**
     * @param $LegID
     * @return Leg
     */
    public function FindLegByID($LegID)
    {
        foreach($this->Legs as $LegObj)
            if($LegObj->Id == $LegID)
                return Leg::Create($LegObj, $this);
    }

    public function getItineraries()
    {
        $its    =   [];
        foreach($this->generateItineraries() as $Itinerary)
            $its[]  =   $Itinerary;

        return $its;
    }

    /**
     * @return \Generator|Itinerary[]
     */
    public function generateItineraries()
    {
        foreach($this->Itineraries as $itobj)
            yield new Itinerary($itobj, $this);;
    }
}