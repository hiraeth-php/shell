<?php

namespace Hiraeth\Shell;

use Hiraeth\Application;

/**
 *
 */
class Prompt
{
	/**
	 * @var Application
	 */
	protected $app;


	/**
	 *
	 */
	public function __construct(Application $app)
	{
		$this->app = $app;
	}


	/**
	 *
	 */
	public function __invoke(): string
	{
		$cwd  = getcwd() ?: '!';
		$home = $this->app->getEnvironment('HOME');
		$root = $this->app->getDirectory()->getRealPath();

		if (str_starts_with($cwd, (string) $root)) {
			$cwd = preg_replace('#^' . $root . '#', '@', $cwd);
		} elseif (str_starts_with($cwd, (string) $home)) {
			$cwd = preg_replace('#^' . $home . '#', '~', $cwd);
		}

		return sprintf('[%s]', $cwd);
	}
}
