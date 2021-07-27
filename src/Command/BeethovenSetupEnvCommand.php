<?php

namespace Beethoven\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

class BeethovenSetupEnvCommand extends Command
{
    protected static $defaultName = 'beethoven:setup-env';

	protected const DESCRIPTION = 'Setup your .env.local file with required information.';
	protected const ENV_KEY = 'APP_ENV';
	protected const ENV_DEV = 'dev';
	protected const ENV_PROD = 'prod';
	protected const DB_KEY = 'DATABASE_URL';
	protected const FILENAME = '.env.local';

	protected function configure(): void
	{
		$this
			->setDescription(self::DESCRIPTION)
		;
	}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
	    $io = new SymfonyStyle($input, $output);

	    $env = strtolower(
		    $io->ask('Which environment do you want to setup (prod, dev)?', self::ENV_PROD)
	    );

	    if($env !== self::ENV_DEV && $env !== self::ENV_PROD) {
		    $io->error(sprintf('\'%s\' is not a valid environment!', $env));
		    return Command::FAILURE;
	    }

	    $dbDriver = $io->ask('db_driver', 'mysql');
	    $dbUser = $io->ask('db_user', 'beethoven');
	    $dbPassword = $io->askHidden('db_password');
	    $dbHost = $io->ask('db_host', '127.0.0.1');
	    $dbPort = $io->ask('db_port', '3306');
	    $dbName = $io->ask('db_name', 'beethoven');
	    $dbVersion = $io->ask('db_version', 'mariadb-10.3.27');

	    $connection = sprintf(
		    '%s://%s:%s@%s:%s/%s?serverVersion=%s',
		    $dbDriver, $dbUser, $dbPassword, $dbHost, $dbPort, $dbName, $dbVersion
	    );

	    $filesystem = new Filesystem();
	    $filesystem->dumpFile(self::FILENAME, sprintf(
		    "%s=%s\n",
		    self::ENV_KEY, $env
	    ));
	    $filesystem->appendToFile(self::FILENAME, sprintf(
		    "%s=%s\n",
		    self::DB_KEY, $connection
	    ));

        $io->success('Successfully created .env.local environment file.');
        return Command::SUCCESS;
    }
}
