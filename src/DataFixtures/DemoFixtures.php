<?php

namespace App\DataFixtures;

use App\Entity\Forum;
use App\Entity\Topic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DemoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    	$forum1 = new Forum();
    	$forum1->setName('Beethoven demo forum');

    	$topic1_1 = new Topic();
    	$topic1_1->setName('Demo topic');
    	$topic1_1->setDescription('This is just a demo topic');
    	$topic1_1->setForum($forum1);
    	$manager->persist($topic1_1);

	    $topic1_2 = new Topic();
	    $topic1_2->setName('Another demo topic');
	    $topic1_2->setForum($forum1);
	    $manager->persist($topic1_2);

	    $manager->persist($forum1);

	    $forum2 = new Forum();
	    $forum2->setName('Beethoven demo forum');

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
