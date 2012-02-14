<?php

use Laravel\CLI\Tasks\Task;

include __DIR__.'/../common.php';

class Bob_Build_Task extends Task
{
	public function controller($params)
	{
		$c = new ControllerGenerator($params);
	}
}
