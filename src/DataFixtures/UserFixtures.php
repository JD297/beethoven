<?php declare(strict_types=1);

namespace Beethoven\DataFixtures;

use Beethoven\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
	public const ADMIN_USER_REFERENCE = 'admin-user';
	public const DEMO_USER_REFERENCE = 'demo-user';

	private UserPasswordHasherInterface $passwordEncoder;

	public function __construct(UserPasswordHasherInterface $passwordEncoder)
	{
		$this->passwordEncoder = $passwordEncoder;
	}

	public function load(ObjectManager $manager): void
	{
		$userDemo = new User();
		$userDemo
			->setUsername('demo')
			->setPassword(
				$this->passwordEncoder->hashPassword(
					$userDemo,
					'demo'
				));
		$manager->persist($userDemo);

		$userAdmin = new User();
		$userAdmin
			->setUsername('admin')
			->setPassword(
				$this->passwordEncoder->hashPassword(
					$userAdmin,
					'admin'
				)
			)
			->setRoles(['ROLE_ADMIN']);
		$manager->persist($userAdmin);

		$manager->flush();

		$this->addReference(self::DEMO_USER_REFERENCE, $userDemo);
		$this->addReference(self::ADMIN_USER_REFERENCE, $userAdmin);
	}
}
