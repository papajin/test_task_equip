<?php

namespace App\Commands;

trait RetrievesOption
{
    protected function getOption( $opt, $default = null )
    {
        $opts = $this->options();

        return $opts[ $opt ] ?? $default;
    }
}