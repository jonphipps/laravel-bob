<?php

/**
 * The main task for the Bob generator, commands are passed as
 * arguments to run()
 *
 * @package 	bob
 * @author 		Dayle Rees
 * @copyright 	Dayle Rees 2012
 * @license 	MIT License <http://www.opensource.org/licenses/mit>
 */
class Bob_Build_Task extends Task
{
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
		$command = ($arguments[0] !== '') ? $arguments[0] : 'help';
		$args = array_slice($arguments, 1);

		switch($command)
		{
			case "controller":
			case "c":
				new Generators_Controller($args);
				break;
			case "model":
			case "m":
				new Generators_Model($args);
				break;
			case "alias":
				new Generators_Alias($args);
				break;
			case "migration":
			case "mig":
				IoC::resolve('task: migrate')->make($args);
				break;
			case "bundle":
			case "b":
				new Generators_Bundle($args);
				break;
			case "test":
			case "t":
				new Generators_Test($args);
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
