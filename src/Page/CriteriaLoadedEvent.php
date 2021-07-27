<?php declare(strict_types=1);

namespace Beethoven\Page;

use Beethoven\Framework\Event\Event;
use Doctrine\Common\Collections\Criteria;

abstract class CriteriaLoadedEvent extends Event
{
	protected Criteria $criteria;

	public function __construct(Criteria $criteria)
	{
		$this->criteria = $criteria;
	}

	/**
	 * @return Criteria
	 */
	public function getCriteria(): Criteria
	{
		return $this->criteria;
	}

	/**
	 * @param Criteria $criteria
	 * @return CriteriaLoadedEvent
	 */
	public function setCriteria(Criteria $criteria): self
	{
		$this->criteria = $criteria;
		return $this;
	}
}