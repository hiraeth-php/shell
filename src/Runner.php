<?php

namespace Hiraeth\Shell;

use Psy\Shell;

/**
 * Provides missing features on top of the classic Psy\Shell
 */
class Runner extends Shell
{
	/**
	 * The dynamic prompt callback
	 *
	 * @var callable|null
	 */
	private $prompt;


	/**
	 * Execute an arbitrary command in the context of the shell
	 */
	public function exec(string $command): mixed
	{
		return $this->runCommand($command);
	}


	/**
	 * Set a custom prompt string
	 */
	public function setPrompt(callable|string $prompt): self
	{
		if (!is_callable($prompt)) {
			$this->prompt = (fn() => (string) $prompt);

		} else {
			$this->prompt = $prompt;
		}

		return $this;
	}


	/**
	 * Get the current prompt
	 *
	 * This will prepend the dynamic prompt to the traditional one.
	 *
	 * @access protected
	 * @return string The current prompt
	 */
	protected function getPrompt()
	{
		return $this->prompt
			? call_user_func($this->prompt) . parent::getPrompt()
			: parent::getPrompt();
	}
}
