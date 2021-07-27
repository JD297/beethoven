<?php declare(strict_types=1);

namespace Beethoven\Page\Home;

use Beethoven\Page\Page;
use Doctrine\ORM\LazyCriteriaCollection;

class HomePage extends Page
{
	public function __construct(LazyCriteriaCollection $forumCollection)
	{
		parent::__construct();
		$this->setForumCollection($forumCollection);
	}

	public function getForumCollection(): LazyCriteriaCollection
	{
		return $this->data->get('forumCollection');
	}

	public function setForumCollection(LazyCriteriaCollection $forumCollection): self
	{
		$this->data->set('forumCollection', $forumCollection);
		return $this;
	}
}