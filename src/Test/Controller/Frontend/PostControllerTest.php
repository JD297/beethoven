<?php declare(strict_types=1);

namespace Beethoven\Test\Controller\Frontend;

use Beethoven\Entity\Post;
use Beethoven\Entity\Topic;
use Beethoven\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\RouterInterface;

class PostControllerTest extends WebTestCase
{
	public function testPostResponseOK(): void
	{
		$client = static::createClient();
		$client->catchExceptions(true);

		/** @var ManagerRegistry $doctrine */
		$em = $this->getContainer()->get('doctrine')->getManager();

		/** @var RouterInterface $router */
		$router = $this->getContainer()->get('router');

		/** @var UserPasswordHasherInterface $passwordHasher */
		$passwordHasher = $this->getContainer()->get('security.user_password_hasher');

		$user = new User();
		$user
			->setUsername('demo')
			->setPassword(
				$passwordHasher->hashPassword(
					$user,
					'demo'
		));

		$topic = new Topic();
		$topic->setName('Test Topic');

		$post = new Post();
		$post->setName('Test Post');
		$post->setContent('Some content for test post.');
		$post->setUser($user);
		$post->setTopic($topic);

		$em->persist($user);
		$em->persist($topic);
		$em->persist($post);
		$em->flush();

		$client->request(Request::METHOD_GET, $router->generate('frontend.post.index.page', [
			'postId' => $post->getId(),
		]));

		$this->assertResponseStatusCodeSame(Response::HTTP_OK);
	}
}
