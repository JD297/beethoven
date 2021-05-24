<?php declare(strict_types=1);

namespace App\Page\Forum;

use App\Framework\Event\Event;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;

class ForumPageCriteriaEvent extends Event
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
	public function setCriteria(Criteria $criteria): void
	{
		$this->criteria = $criteria;
	}
}