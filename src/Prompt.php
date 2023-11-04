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

		if (strpos($cwd, $root) === 0) {
			$cwd = preg_replace('#^' . $root . '#', '@', $cwd);
		} elseif (strpos($cwd, $home) === 0) {
			$cwd = preg_replace('#^' . $home . '#', '~', $cwd);
		}

		return sprintf('[%s]', $cwd);
	}
}
