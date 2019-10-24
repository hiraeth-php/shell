<?php

namespace Hiraeth\Shell;

use Hiraeth;
use Psy\Configuration;

/**
 *
 */
class RunnerDelegate implements Hiraeth\Delegate
{
	/**
	 * Get the class for which the delegate operates.
	 *
	 * @static
	 * @access public
	 * @return string The class for which the delegate operates
	 */
	static public function getClass(): string
	{
		return Runner::class;
	}


	/**
	 * Get the instance of the class for which the delegate operates.
	 *
	 * @access public
	 * @param Hiraeth\Application $app The application instance for which the delegate operates
	 * @return Runner The instance of our logger
	 */
	public function __invoke(Hiraeth\Application $app): object
	{
		$prompt = $app->getConfig('packages/shell', 'prompt', Prompt::class);
		$runner = new Runner($app->get(Configuration::class));

		foreach ($app->getConfig('*', 'shell.commands') as $commands) {
			foreach ($commands as $command) {
				$runner->add($app->get($command));
			}
		}

		if ($prompt) {
			$runner->setPrompt($app->get($prompt));
		}

		return $runner;
	}
}
