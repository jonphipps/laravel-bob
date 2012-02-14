<?php

use Laravel\CLI\Tasks\Task;

include __DIR__.'/../common.php';

/**
 * Common functions for dealing with templates.
 *
 * @author  Dayle Rees.
 * @copyright  Dayle Rees 2012.
 * @package  bob
 */
class Bob_Build_Task extends Task
{
	/**
	 * Engage controller creation! MAKE IT SO
	 */
	public function controller($params)
	{
		$c = new ControllerGenerator($params);
	}

	public function model($params)
	{
		$e = new EloquentGenerator($params);
	}

	public function run()
	{
		Common::log('Available commands:');
		Common::log("\t controller");
	}
}
