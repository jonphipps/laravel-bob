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
class Bob__Task extends Task
{
	/**
	 * Engage controller creation! MAKE IT SO
	 */
	public function run($params = array())
	{
		$cmd = $params[0];
		$params = array_slice($params,1);

		switch (Str::lower($cmd))
		{
			case "controller":
				$c = new ControllerGenerator($params);
				break;
			case "m":
				$c = new EloquentGenerator($params);
				break;
		}
	}
}
