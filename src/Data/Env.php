<?php

namespace App\Data;

class Env extends \Equip\Env
{
	public function getPath(string $key, $default = null)
	{
		return Arr::getPath( $this->values, $key, $default );
	}
}