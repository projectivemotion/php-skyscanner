<?php
/**
 * Project: php-skyscanner
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\phpSkyscanner;


class AgentPrice
{
    public $AgentId =   0;
    public $Price   =   NULL;
    public $DeeplinkUrl =   '';
    public $QuoteAgeInMinutes   =   0;

    /**
     * @param $agentdata
     * @return static
     */
    public static function Create($agentdata)
    {
        $self   =   new static;
        $self->Price    =   $agentdata->Price;
        $self->AgentId  =   $agentdata->Agents[0];
        $self->DeeplinkUrl  =   $agentdata->DeeplinkUrl;
        $self->QuoteAgeInMinutes    =   $agentdata->QuoteAgeInMinutes;
        return $self;
    }
}