<?php

namespace Hiraeth\Shell;

/**
 *
 */
class Prompt
{
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
	public function __invoke()
	{
		$cwd  = getcwd();
		$root = $this->app->getDirectory();
		$home = $this->app->getEnvironment('HOME');
		if (strpos($cwd, $root) === 0) {
			$cwd = preg_replace('#^' . $root . '#', '@', $cwd);
		} elseif (strpos($cwd, $home) === 0) {
			$cwd = preg_replace('#^' . $home . '#', '~', $cwd);
		}

		return sprintf('[%s]', $cwd);
	}
}
