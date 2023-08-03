<?php


namespace App\Domain;


use Equip\Adr\Status;

class Index extends Domain
{

	/**
	 * @inheritDoc
	 */
	public function __invoke( array $input )
    {
		return $this->payload
			->withStatus(Status::STATUS_OK)
			->withSetting('template', 'index')
			->withOutput(['message' => 'Hello World!']);
	}
}