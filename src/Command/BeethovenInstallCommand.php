<?php declare(strict_types=1);

namespace App\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

class BeethovenInstallCommand extends Command
{
    protected static $defaultName = 'beethoven:install';

    protected const DESCRIPTION = 'Installs beethoven with basic setup';

    protected function configure(): void
    {
        $this
            ->setDescription(self::DESCRIPTION)
        ;
    }

	/**
	 * @throws Exception
	 */
	protected function execute(InputInterface $input, OutputInterface $output): int
    {
	    $io = new SymfonyStyle($input, $output);

		$this->doctrineDatabaseCreate($output);
		$this->doctrineMigrationsMigrate($output);

	    $io->info('You should at least set the \'ROLE_ADMIN role\' for the first user!');
		$this->beethovenCreateUser($output);

        $io->success('Beethoven was successfully installed.');
        return Command::SUCCESS;
    }

	/**
	 * @throws Exception
	 */
	private function doctrineDatabaseCreate(OutputInterface $output): void
	{
	    $command = $this->getApplication()->find('doctrine:database:create');

		$input = new ArrayInput([]);
		$input->setInteractive(false);
		$command->run($input, $output);
	}

	/**
	 * @throws Exception
	 */
	private function doctrineMigrationsMigrate(OutputInterface $output): void
	{
		$command = $this->getApplication()->find('doctrine:migrations:migrate');

		$input = new ArrayInput([]);
		$input->setInteractive(false);
		$command->run($input, $output);
	}

	/**
	 * @throws Exception
	 */
	private function beethovenCreateUser(OutputInterface $output): void
	{
		$command = $this->getApplication()->find('beethoven:create-user');

		$input = new ArrayInput([]);
		$command->run($input, $output);
	}
}
