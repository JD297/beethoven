<?php declare(strict_types=1);

namespace App\Page;

use App\Framework\Event\Event;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;

abstract class CriteriaLoadedEvent extends Event
{
	protected Criteria $criteria;

	public function __construct(Criteria $criteria, Request $request)
	{
		$this->criteria = $criteria;
		parent::__construct($request);
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
	 */
	public function setCriteria(Criteria $criteria): self
	{
		$this->criteria = $criteria;
		return $this;
	}
}