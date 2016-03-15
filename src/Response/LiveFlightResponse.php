<?php
/**
 * Project: php-skyscanner
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\phpSkyscanner\Response;


class LiveFlightResponse extends \ArrayObject
{
    protected $Status   =   '';

    public function __construct($input)
    {
        parent::__construct($input, \ArrayObject::ARRAY_AS_PROPS);
    }


    public function setStatus($Status)
    {
        $this->Status = $Status;
    }

    public function getStatus()
    {
        return $this->Status;
    }

    public static function Create($json_response)
    {
        $self   =   new static((array)$json_response);
        return $self;
    }
}