<?php

use Laravel\CLI\Tasks\Task;
use Laravel\Str;

class Bob_Forge_Task extends Task
{
	public function controller($params)
	{
		if (! count($params)) throw new \Exception('Need controller name.');

		$controller['name'] 	= $params[0];
		$controller['class'] 	= Str::classify($params[0]);
		$controller['lower'] 	= Str::lower($params[0]);

		$source = $this->_get_source('controller.tpl', $controller);

		$this->_save(path('app').'controllers/'.$controller['lower'].EXT, $source);
	}

	private function _get_source($template, $map)
	{
		$templates = path('bundle').'bob/templates/';

		$parsed = file_get_contents($templates.$template);

		foreach ($map as $key => $val)
		{
			$parsed = str_replace('%%'.Str::upper($key).'%%', $val, $parsed);
		}

		return $parsed;
	}

	private function _save($file, $contents)
	{
		if (file_put_contents($file, $contents) === false)
			throw new \Exception("Unable to write to destination.");
	}

	private function _log($message)
	{
		echo $message. "\n";
	}		
}