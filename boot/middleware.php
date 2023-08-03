<?php


return [
	Relay\Middleware\ResponseSender::class,
	Equip\Handler\ExceptionHandler::class,
	Equip\Handler\DispatchHandler::class,
	Equip\Handler\JsonContentHandler::class,
	Equip\Handler\FormContentHandler::class,
	Equip\Handler\ActionHandler::class,
];