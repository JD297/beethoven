<?php declare(strict_types=1);

namespace Beethoven\Test\Controller\Frontend;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class PostControllerTest extends WebTestCase
{
	public function testTopicResponseOK(): void
	{
		$client = static::createClient();
		$client->catchExceptions(true);

		/** @var ManagerRegistry $doctrine */
		$em = $this->getContainer()->get('doctrine')->getManager();

		/** @var RouterInterface $router */
		$router = $this->getContainer()->get('router');

		$post = new Post();
		$post->setName('Test Post');

		$em->persist($post);
		$em->flush();

		$client->request(Request::METHOD_GET, $router->generate('frontend.topic.index.page', [
			'topicId' => $post->getId(),
		]));

		$this->assertResponseStatusCodeSame(Response::HTTP_OK);
	}
}
