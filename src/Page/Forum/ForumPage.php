<?php declare(strict_types=1);

namespace App\Page\Forum;

use App\Page\Page;
use Doctrine\ORM\LazyCriteriaCollection;

class ForumPage extends Page
{
	protected LazyCriteriaCollection $forumCollection;

	/**
	 * @return LazyCriteriaCollection
	 */
	public function getForumCollection(): LazyCriteriaCollection
	{
		return $this->forumCollection;
	}

	/**
	 * @param LazyCriteriaCollection $forumCollection
	 */
	public function setForumCollection(LazyCriteriaCollection $forumCollection): void
	{
		$this->forumCollection = $forumCollection;
	}

	/**
	 * @return array
	 */
	public function getForums(): array
	{
		return $this->forumCollection->toArray();
	}
}