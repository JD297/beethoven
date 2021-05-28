<?php declare(strict_types=1);

namespace App\Page\Topic;

use App\Entity\Topic;
use App\Page\Page;

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