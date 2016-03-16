<?php
/**
 * Project: php-skyscanner
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\phpSkyscanner\Response;


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
}