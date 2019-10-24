<?php

namespace Hiraeth\Shell;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShellCommand extends Command
{
	/**
	 *
	 */
	protected static $defaultName = 'shell';


	/**
	 *
	 */
	public function __construct(Runner $shell)
	{
		$this->shell = $shell;

		parent::__construct();
	}


	/**
	 *
	 */
	protected function configure()
	{
		$this->setDescription('Execute an interactive shell');
	}


	/**
	 *
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		return $this->shell->run();
	}
}
