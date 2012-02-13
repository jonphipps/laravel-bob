<?php

use Laravel\CLI\Tasks\Task;
use Laravel\Str;

class Bob_Build_Task extends Task
{
	public function controller($params)
	{
		if(count($params) > 0)
		{
			$controller['name'] = $params[0];
			$controller['lower'] = strtolower($params[0]);
			$controller['class'] = Str::classify($controller['name'].'_Controller');
			unset($params[0]);
			$controller['actions'] = $params;

			$controller_template = file_get_contents(path('bundle').'bob/templates/controller.tpl');
			$controller_template = str_replace('%%NAME%%', $controller['class'], $controller_template);

			file_put_contents(path('app').'controllers/'.$controller['lower'].EXT, $controller_template);
			echo "Controller created.";
		}
		else
		{
			throw new \Exception("You must specify a controller name.");
		}
	}

	public function model($params)
	{

	}
}
