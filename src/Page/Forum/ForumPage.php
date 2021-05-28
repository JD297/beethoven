<?php declare(strict_types=1);

namespace App\Page\Forum;

use App\Entity\Forum;
use App\Page\Page;

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