<?php
/**
 * Project: php-skyscanner
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\phpSkyscanner\Request;


class LiveFlightQuery // extends \ArrayObject
{
    protected $locale;
    protected $adults;
    protected $apiKey;
    protected $country;
    protected $originplace;
    protected $inbounddate;
    protected $outbounddate;
    protected $groupPricing;
    protected $carrierschema;
    protected $locationschema;
    protected $includecarriers;
    protected $destinationplace;

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function __construct($input = [])
    {
//        parent::__construct($input, \ArrayObject::ARRAY_AS_PROPS);
    }

    public function setGroupPricing($groupPricing)
    {
        $this->groupPricing = $groupPricing;
    }

    public function getGroupPricing()
    {
        return $this->groupPricing;
    }

    public function setCountry($country)
    {
        $this->country  =   $country;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey   =   $apiKey;
    }

    public function setLocale($locale)
    {
        $this->locale   =   $locale;
    }

    public function setOriginPlace($originplace)
    {
        $this->originplace  =   $originplace;
    }

    public function setDestinationPlace($destinationplace)
    {
        $this->destinationplace    =   $destinationplace;
    }

    public function setIncludeCarriers($includecarriers)
    {
        $this->includecarriers  =   $includecarriers;
    }

    public function setOutboundDate($outbounddate)
    {
        $this->outbounddate =   $outbounddate;
    }

    public function setInboundDate($inbounddate)
    {
        $this->inbounddate = $inbounddate;
    }

    public function setAdults($adults)
    {
        $this->adults   =   $adults;
    }

    public function setCurrency($currencycode)
    {
        $this->currency =   $currencycode;
    }

    public function asArray()
    {
        return get_object_vars($this);
    }

    public function setLocationSchema($locationschema)
    {
        $this->locationschema = $locationschema;
    }

    public function setCarrierschema($carrierschema)
    {
        $this->carrierschema = $carrierschema;
    }
}