<?php

/**
 * The main task for the Bob generator, commands are passed as
 * arguments to run()
 *
 * @package bob
 * @author Dayle Rees
 * @copyright Dayle Rees 2012
 */
class Bob_Build_Task extends Task
{
	/**
	 * The default command, show help.
	 *
	 * @var string
	 */
	private $_command = 'help';

	/**
	 * Arguments to the command.
	 *
	 * @var array
	 */
	private $_args = array();


	/**
	 * run() is the start-point of the CLI request, the
	 * first argument specifies the command, and sub-sequent
	 * arguments are passed as arguments to the chosen generator.
	 *
	 * @param $arguments array The command and its arguments.
	 * @return void
	 */
	public function run($arguments = array())
	{
		if (! count($arguments)) $this->_help();

		// assign the params
		$this->_command = $arguments[0];
		$this->_args = array_slice($arguments, 1);

		// fire off the navigation
		$this->_navigate();
	}

	/**
	 * Determine the active command and fire off
	 * a suitable generation handler.
	 *
	 * @return void
	 */
	private function _navigate()
	{
		Common::log(chr(27).'[36m'.'--B-O-B---------------------------------------'.chr(27)."[0m");

		switch($this->_command)
		{
			case "controller":
			case "c":
				$c = new Generators_Controller($this->_args);
				$c->generate();
				break;
			case "model":
			case "m":
				$m = new Generators_Model($this->_args);
				$m->generate();
				break;
			case "alias":
				$a = new Generators_Alias($this->_args);
				$a->generate();
				break;
			case "migration":
			case "mig":
				IoC::resolve('task: migrate')->make($this->_args);
				break;
			case "bundle":
			case "b":
				$b = new Generators_Bundle($this->_args);
				$b->generate();
				break;
			case "test":
			case "t":
				$t = new Generators_Test($this->_args);
				$t->generate();
				break;
			default:
				$this->_help();
				break;


		}
	}

	/**
	 * Show a short version of the documentation to hint
	 * at command names, with an example.
	 *
	 * @return void
	 */
	private function _help()
	{
		Common::error('Please specify a command.');
	}
}
