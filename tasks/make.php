<?php

use Laravel\CLI\Tasks\Task;
use Laravel\Str;

class Bob_Make_Task extends Task
{

	private $params = array();


	public function controller($params)
	{
		$this->params = $params;

		if (count($this->params) > 0)
		{
			$controller = $this->_replace('controller.tpl');
			$this->_log("[+] Controller '" . Str::classify($this->params[0]) . "_Controller'");
			$this->_log("\t- Action\t'".Str::lower($this->params[0])."@index'");
			$this->_save(path('app').'controllers/'.Str::lower($this->params[0]).EXT, $controller);

			$this->_log("\t- View\t\t'" . Str::lower($this->params[0])."/index.blade.php'");
			@mkdir(path('app').'views/'. Str::lower($this->params[0]));
			$this->_save(path('app').'views/'. Str::lower($this->params[0]) . '/index.blade.php', '');

		}
		else
		{
			throw new \Exception("You must specify a controller name.");
		}
	}

	private function _replace($template)
	{
		$templates = path('bundle').'bob/templates/';

		$parsed = file_get_contents($templates.$template);

		foreach ($this->params as $key => $val)
		{
			$parsed = str_replace("%%$key%%", $val, $parsed);
			$parsed = str_replace("%%U$key%%", Str::upper($val), $parsed);
			$parsed = str_replace("%%L$key%%", Str::lower($val), $parsed);
			$parsed = str_replace("%%C$key%%", Str::classify($val), $parsed);
		}

		return $parsed;
	}

	private function _log($message)
	{
		echo $message. "\n";
	}

	private function _save($file, $contents)
	{
		if (file_put_contents($file, $contents) === false)
			throw new \Exception("Unable to write to destination.");
	}
}