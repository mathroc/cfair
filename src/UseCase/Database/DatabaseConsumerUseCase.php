<?php

namespace CFair\UseCase\Database;

use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use CFair\UseCase\ConsumerUseCase;

class DatabaseConsumerUseCase implements ConsumerUseCase {
	private $connection;
	private $logger;

	public function __construct(Connection $connection, LoggerInterface $logger)
	{
		$this->connection = $connection;
		$this->logger     = $logger;
	}

	public function consume(Array $message)
	{
		$this->connection->insert('job', ['payload' => json_encode($message)]);
		$id = $this->connection->lastInsertId();
		$this->logger->notice('New job has been queued', ['id' => $id]);
		return $id;
	}
}
