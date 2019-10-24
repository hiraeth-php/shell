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
	 * @access private
	 * @var callable
	 */
	private $prompt = NULL;


	/**
	 * Execute an arbitrary command in the context of the shell
	 *
	 * @access public
	 * @var string $command The command to execute
	 * @return mixed The result of the command execution
	 */
	public function exec($command)
	{
		return $this->runCommand($command);
	}


	/**
	 * Set a custom prompt string
	 *
	 * @access public
	 * @var string|callable $prompt A prompt or callable to generate a prompt
	 * @return void
	 */
	public function setPrompt($prompt)
	{
		if (!is_callable($prompt)) {
			$this->prompt = function() use ($prompt) {
				return (string) $prompt;
			};

		} else {
			$this->prompt = $prompt;
		}
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
