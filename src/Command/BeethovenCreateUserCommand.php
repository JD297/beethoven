<?php

namespace Beethoven\Command;

use Beethoven\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BeethovenCreateUserCommand extends Command
{
    protected static $defaultName = 'beethoven:create-user';
    protected const DESCRIPTION = 'Create a user';

	/**
	 * @var UserPasswordEncoderInterface $passwordEncoder
	 */
	private UserPasswordEncoderInterface $passwordEncoder;

	/**
	 * @var EntityManagerInterface $em
	 */
	private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder, string $name = null)
    {
	    parent::__construct($name);

	    $this->em = $em;
	    $this->passwordEncoder = $passwordEncoder;
    }

	protected function configure(): void
    {
        $this
            ->setDescription(self::DESCRIPTION)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $username = $io->ask('Username');
        $password = $io->askHidden('Password');

        $roles = [];

		while(true) {
			$role = $io->ask('Add role e.g. ROLE_ADMIN (LEAVE EMPTY AND PRESS ENTER to continue)');

			if (!$role) {
				break;
			}

			$roles[] = $role;
		}

		$roles = array_unique($roles);

	    $user = new User();
		$user
			->setUsername($username)
			->setPassword($this->passwordEncoder->encodePassword(
				$user,
				$password
			))
			->setRoles($roles)
		;

		$this->em->persist($user);
		$this->em->flush();

        $io->success(sprintf('User %s was successfully created.', $user->getUsername()));
        return Command::SUCCESS;
    }
}
