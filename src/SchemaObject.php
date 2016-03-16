<?php
/**
 * Project: php-skyscanner
 *
 * @author Amado Martinez <amado@projectivemotion.com>
 */

namespace projectivemotion\phpSkyscanner;


class SchemaObject
{
    public static function Create($data)
    {
        $self   =   new static;
        foreach($data as $key => $value)
            $self->$key =   $value;

        return $self;
    }
}