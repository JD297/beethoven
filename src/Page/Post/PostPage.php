<?php declare(strict_types=1);

namespace Beethoven\Page\Post;

use Beethoven\Entity\Post;
use Beethoven\Page\Page;

class PostPage extends Page
{
	public function __construct(Post $post)
	{
		parent::__construct();
		$this->setPost($post);
	}

	public function getPost(): Post
	{
		return $this->data->get('post');
	}

	public function setPost(Post $post): self
	{
		$this->data->set('post', $post);

		return $this;
	}
}
