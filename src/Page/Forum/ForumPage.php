<?php declare(strict_types=1);

namespace Beethoven\Page\Forum;

use Beethoven\Entity\Forum;
use Beethoven\Page\Page;

class ForumPage extends Page
{
	public function __construct(Forum $forum)
	{
		parent::__construct();
		$this->setForum($forum);
	}

	public function getForum(): Forum
	{
		return $this->data->get('forum');
	}

	public function setForum(Forum $forum): self
	{
		$this->data->set('forum', $forum);

		return $this;
	}
}
