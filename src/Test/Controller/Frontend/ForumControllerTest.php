<?php declare(strict_types=1);

namespace Beethoven\Test\Controller\Frontend;

use Beethoven\Entity\Forum;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ForumControllerTest extends WebTestCase
{
	public function testResponseOK(): void
	{
		$client = static::createClient();
		$client->catchExceptions(true);

		$this->assertResponseStatusCodeSameWithForumId($client, Response::HTTP_OK, $this->getFirstForumId());

		$this->assertResponseStatusCodeSameWithForumId($client, Response::HTTP_NOT_FOUND, 0);
	}

	private function getFirstForumId(): int
	{
		/** @var ManagerRegistry $doctrine */
		$doctrine = $this->getContainer()->get('doctrine');

		$forum = $doctrine->getRepository(Forum::class)
			->findOneBy(['active' => true]);
		;

		if (!$forum instanceof Forum) {
			return 0;
		}

		return $forum->getId();
	}

	private function generateForumPageUri(int $id): string
	{
		return $this->getContainer()->get('router')->generate('frontend.forum.index.page', [
			'forumId' => $id,
		]);
	}

	private function assertResponseStatusCodeSameWithForumId(KernelBrowser $client, int $expectedCode, $id): void
	{
		$client->request(
			Request::METHOD_GET, $this->generateForumPageUri($id)
		);
		$this->assertResponseStatusCodeSame($expectedCode);
	}
}
