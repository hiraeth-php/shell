<?php

namespace Hiraeth\Shell;

use Hiraeth;
use RuntimeException;
use Psy\Configuration;

/**
 *
 */
class RunnerDelegate implements Hiraeth\Delegate
{
	/**
	 * {@inheritDoc}
	 */
	static public function getClass(): string
	{
		return Runner::class;
	}


	/**
	 * {@inheritDoc}
	 */
	public function __invoke(Hiraeth\Application $app): object
	{
		$prompt = $app->getConfig('packages/shell', 'shell.prompt', Prompt::class);
		$runner = new Runner($app->get(Configuration::class));
		$scope  = ['app' => $app];

		foreach ($app->getConfig('*', 'shell.variables', []) as $path => $variables) {
			foreach ($variables as $name => $class) {
				if (isset($scope[$name])) {
					throw new RuntimeException(sprintf(
						'Cannot set variable "%s" in scope, from config %s, already set.',
						$name,
						$path
					));
				}

				$scope[$name] = $app->get($class);
			}
		}

		foreach ($app->getConfig('*', 'shell.commands', []) as $commands) {
			foreach ($commands as $command) {
				$runner->add($app->get($command));
			}
		}

		if ($prompt) {
			$runner->setPrompt($app->get($prompt));
		}

		$runner->setScopeVariables($scope);

		return $runner;
	}
}
