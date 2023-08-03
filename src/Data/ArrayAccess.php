<?php

namespace App\Data;

trait ArrayAccess
{
    public function offsetExists($offset): bool
    {
        return $this->has( $offset );
    }

    public function offsetGet($offset)
    {
        return $this->{$offset};
    }

    public function offsetSet($offset, $value)
    {
        return $this->{$offset} = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->{$offset});
    }
}