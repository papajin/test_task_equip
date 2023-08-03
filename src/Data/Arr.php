<?php

namespace App\Data;

use function Equip\Arr\exists;
use function Equip\Arr\to_array;

class Arr {
	public static function getPath( $source, $path, $default = null )
	{
		$parts = explode( '.', $path );
		$node  = $source;

		foreach ( $parts as $part ) {
			if ( ! exists( $node, $part ) ) {
				return $default;
			}

			$node = to_array( $node )[ $part ];
		}

		return $node;
	}
}