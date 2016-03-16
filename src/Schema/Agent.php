<?php
/**
 * Project: php-skyscanner
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\phpSkyscanner\Schema;


use projectivemotion\phpSkyscanner\SchemaObject;

class Agent extends SchemaObject
{
    public $Id;
    public $Name;
    public $ImageUrl;
    public $Status;
    public $OptimisedForMobile;
    public $BookingNumber;
    public $Type;
}