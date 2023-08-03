<?php


namespace App;


use Equip\Directory;
use App\Domain;

class Routing {

	public function __invoke(Directory $directory)
	{
		return $directory
			->get('/', Domain\Index::class)
			->post('/api', Domain\Api::class)
		; // End of routing
	}

}