<?php declare(strict_types=1);

namespace App\Page;

use App\Framework\Event\Event;

abstract class EntityEvent extends Event
{
	protected object $entity;

	public function __construct(object $entity)
	{
		$this->entity = $entity;
	}

	/**
	 * @return object
	 */
	public function getEntity(): object
	{
		return $this->entity;
	}

	/**
	 * @param object $entity
	 */
	public function setEntity(object $entity): void
	{
		$this->entity = $entity;
	}
}