<?php declare(strict_types=1);

namespace Beethoven\Test\Controller\Frontend;

use Beethoven\Entity\Forum;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class ForumControllerTest extends WebTestCase
{
	public function testForumResponseOK(): void
	{
		$client = static::createClient();
		$client->catchExceptions(true);

		/** @var ManagerRegistry $doctrine */
		$em = $this->getContainer()->get('doctrine')->getManager();

		/** @var RouterInterface $router */
		$router = $this->getContainer()->get('router');

		$forum = new Forum();
		$forum->setName('Beethoven Test Forum');

		$em->persist($forum);
		$em->flush();

		$client->request(Request::METHOD_GET, $router->generate('frontend.forum.index.page', [
			'forumId' => $forum->getId(),
		]));

		$this->assertResponseStatusCodeSame(Response::HTTP_OK);
	}
}
