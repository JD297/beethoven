<?php declare(strict_types=1);

namespace Beethoven\DataFixtures;

use Beethoven\Entity\Comment;
use Beethoven\Entity\Forum;
use Beethoven\Entity\Post;
use Beethoven\Entity\Topic;
use Beethoven\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DemoFixtures extends Fixture implements DependentFixtureInterface
{
	public const FORUM_NAMES = [
		'Beethoven demo forum I',
		'Beethoven demo forum II',
	];

	public const TOPICS = [
		[
			'name' => 'Demo topic',
			'description' => 'This is just a demo topic',
		],
		[
			'name' => 'Another demo topic',
			'description' => '',
		],
	];

	public const POST_NAME = 'Beethoven demo post %d';

	public const POST_CONTENT = 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.

Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.';

	public const COMMENT_CONTENT = 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.

Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat.';

	public const NUMBER_OF_POSTS = 64;

	public const NUMBER_OF_COMMENTS = 48;

	public function load(ObjectManager $manager): void
	{
		/** @var User $demoUser */
		$demoUser = $this->getReference(UserFixtures::DEMO_USER_REFERENCE);

		foreach (self::FORUM_NAMES as $forumName) {
			$forum = new Forum();
			$forum->setName($forumName);
			$manager->persist($forum);

			foreach (self::TOPICS as $topicData) {
				$topic = new Topic();
				$topic->setName($topicData['name']);
				$topic->setDescription($topicData['description']);
				$topic->setForum($forum);
				$manager->persist($topic);

				if (self::TOPICS[0] === $topicData) {
					foreach (range(1, self::NUMBER_OF_POSTS) as $postNumber) {
						$post = new Post();
						$post
							->setName(sprintf(self::POST_NAME, $postNumber))
							->setContent(self::POST_CONTENT)
							->setTopic($topic)
							->setUser($demoUser)
						;
						$manager->persist($post);

						if (1 === $postNumber) {
							foreach (range(1, self::NUMBER_OF_COMMENTS) as $commentNumber) {
								$comment = new Comment();
								$comment
									->setContent(self::COMMENT_CONTENT)
									->setUser($demoUser)
									->setPost($post)
								;
								$manager->persist($comment);
							}
						}
					}
				}
			}
		}

		$manager->flush();
	}

	public function getDependencies(): array
	{
		return [
			UserFixtures::class,
		];
	}
}
