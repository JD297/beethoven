<?php

namespace App\DataFixtures;

use App\Entity\Forum;
use App\Entity\Post;
use App\Entity\Topic;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DemoFixtures extends Fixture
{
	/**
	 * @var UserPasswordEncoderInterface $passwordEncoder
	 */
	private UserPasswordEncoderInterface $passwordEncoder;

	public function __construct(UserPasswordEncoderInterface $passwordEncoder)
	{
		$this->passwordEncoder = $passwordEncoder;
	}

	public function load(ObjectManager $manager)
    {
		$user = new User();
		$user
		    ->setUsername('demo')
		    ->setPassword(
			    $this->passwordEncoder->encodePassword(
				    $user,
				    'demo'
		    ));
		$manager->persist($user);

    	$forum1 = new Forum();
		$forum1->setName('Beethoven demo forum I');

    	$topic1_1 = new Topic();
    	$topic1_1->setName('Demo topic');
    	$topic1_1->setDescription('This is just a demo topic');
    	$topic1_1->setForum($forum1);
    	$manager->persist($topic1_1);

		$post1_1_1 = new Post();
		$post1_1_1
		    ->setName('Demo Post in demo topic 1')
		    ->setContent('Content in Demo Post 1')
		    ->setTopic($topic1_1)
		    ->setUser($user)
	    ;
		$manager->persist($post1_1_1);

	    $post1_1_2 = new Post();
	    $post1_1_2
		    ->setName('Demo Post in demo topic 2')
		    ->setContent('Content in Demo Post 2')
		    ->setTopic($topic1_1)
		    ->setUser($user)
	    ;
	    $manager->persist($post1_1_2);

	    $topic1_2 = new Topic();
	    $topic1_2->setName('Another demo topic');
	    $topic1_2->setForum($forum1);
	    $manager->persist($topic1_2);

	    $manager->persist($forum1);

	    $forum2 = new Forum();
	    $forum2->setName('Beethoven demo forum II');

	    $topic2_1 = new Topic();
	    $topic2_1->setName('Demo topic');
	    $topic2_1->setDescription('This is just a demo topic');
	    $topic2_1->setForum($forum2);
	    $manager->persist($topic2_1);

	    $topic2_2 = new Topic();
	    $topic2_2->setName('Another demo topic');
	    $topic2_2->setForum($forum2);
	    $manager->persist($topic2_2);

	    $topic2_3 = new Topic();
	    $topic2_3->setName('Third demo topic');
	    $topic2_3->setDescription('This is the 3th topic in the 2nd forum');
	    $topic2_3->setForum($forum2);
	    $manager->persist($topic2_3);

	    $manager->persist($forum2);

        $manager->flush();
    }
}
