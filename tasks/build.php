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
		Common::log('--B-O-B---------------------------------------');

		switch($this->_command)
		{
			case "controller":
			case "c":
				Generators_Controller::go($this->_args);
				break;
			case "model":
			case "m":
				Generators_Model::go($this->_args);
				break;
			case "alias":
				Generators_Alias::go($this->_args);
				break;
			case "migration":
			case "mig":
				IoC::resolve('task: migrate')->make($this->_args);
				break;
			case "bundle":
			case "b":
				Generators_Bundle::go($this->_args);
				break;
			case "test":
			case "t":
				Generators_Test::go($this->_args);
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
