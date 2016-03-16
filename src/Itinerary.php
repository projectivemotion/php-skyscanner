<?php
/**
 * Project: php-skyscanner
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\phpSkyscanner;


use projectivemotion\phpSkyscanner\Response\LiveFlightResponse;
use projectivemotion\phpSkyscanner\Schema\FlightNumber;

class Itinerary
{
    /**
     * @var LiveFlightResponse
     */
    protected $Response =   NULL;
    
    protected $OutboundLegId    =   NULL;
    protected $InboundLegId    =   NULL;

    /**
     * @var Leg
     */
    protected $OutboundLeg  =   NULL;

    /**
     * @var Leg
     */
    protected $InboundLeg   =   NULL;

    protected $OutboundLegID    =   NULL;
    protected $BookingDetailsLink   =   NULL;
    protected $PricingOptions   =   NULL;

    public function __construct($it_obj, LiveFlightResponse $R)
    {
        $this->Response =   $R;
        
        // copy object values
        
        foreach($it_obj as $copyName => $copyValue)
            $this->$copyName    =   $copyValue;        
    }

    public function setOutboundLeg($OutboundLeg)
    {
        $this->OutboundLeg = $OutboundLeg;
    }

    public function getOutboundLeg()
    {
        if(!$this->OutboundLeg)
        {
            $this->setOutboundLeg($this->Response->FindLegByID($this->OutboundLegId));
        }
        return $this->OutboundLeg;
    }

    public function setInboundLeg($InboundLeg)
    {
        $this->InboundLeg = $InboundLeg;
    }

    public function getInboundLeg()
    {
        if(!$this->InboundLeg)
        {
            $this->setInboundLeg($this->Response->FindLegByID($this->InboundLegId));
        }
        return $this->InboundLeg;
    }

    public function IsOutboundDirect()
    {
        return $this->getOutboundLeg()->IsDirectFlight();
    }

    public function IsInboundDirect()
    {
        return $this->getInboundLeg()->IsDirectFlight();
    }

    public function IsCarrierID($CarrierID)
    {
        return count($this->getOutboundLeg()->Carriers) == 1 &&
                count($this->getInboundLeg()->Carriers) == 1 &&
                $this->getOutboundLeg()->Carriers[0]    == $this->getOutboundLeg()->Carriers[0] &&
                $this->getOutboundLeg()->Carriers[0] == $CarrierID;
    }

    /**
     * @return \Generator|AgentPrice[]
     */
    public function generateAgentPrices()
    {
        foreach($this->PricingOptions as $pricedata)
            yield AgentPrice::Create($pricedata);
    }

    /**
     * @param $agent_id
     * @return null|AgentPrice
     */
    public function getAgentPrice($agent_id)
    {
        foreach($this->generateAgentPrices() as $price)
            if($price->AgentId  ==  $agent_id)
                return $price;

        return NULL;
    }

    /**
     * @param string $direction Outbound|Inbound
     * @return FlightNumber[]
     */
    public function getFlightNumbers($direction = 'Outbound')
    {
        $Leg    =   $direction  ==  'Outbound' ? $this->getOutboundLeg() : $this->getInboundLeg();
        return $Leg->getFlightNumbers();
    }
}
