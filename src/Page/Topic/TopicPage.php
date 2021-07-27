<?php declare(strict_types=1);

namespace Beethoven\Page\Topic;

use Beethoven\Entity\Topic;
use Beethoven\Page\Page;

class TopicPage extends Page
{
	public function __construct(Topic $topic)
	{
		parent::__construct();
		$this->setTopic($topic);
	}

	public function getTopic(): Topic
	{
		return $this->data->get('topic');
	}

	public function setTopic(Topic $topic): self
	{
		$this->data->set('topic', $topic);
		return $this;
	}
}