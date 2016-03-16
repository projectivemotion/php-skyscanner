<?php
/**
 * Project: php-skyscanner
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\phpSkyscanner\Schema;


use projectivemotion\phpSkyscanner\SchemaObject;

class Carrier extends SchemaObject
{
    public $Id;
    public $Code;
    public $Name;
    public $DisplayCode;
}