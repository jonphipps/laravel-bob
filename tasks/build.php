<?php

use Laravel\CLI\Tasks\Task;
use Laravel\Str;

class Bob_Build_Task extends Task
{
	public function controller($params)
	{
		if(count($params) > 0)
		{
			$map['1'] = Str::classify($params[0].'_Controller');
			$map['2'] = strtolower($params[0]);

			unset($params[0]);

			echo "[+] Controller '{$map['1']}'\n\t- Action 'index'\n\t- View '{$map['2']}/index.blade.php'\n";
			$actions = '';
			foreach ($params as $action)
			{
				$actions .= $this->template_replace('action.tpl', array(
					'1' => strtolower($action)
				));
				echo "\t- Action '" . strtolower($action) . "'\n\t- View '{$map['2']}/" . strtolower($action) . ".blade.php'\n";
			}

			$map['3'] = $actions;

			$template = $this->template_replace('controller.tpl', $map);

			file_put_contents(path('app').'controllers/'.$map['2'].EXT, $template);

			echo "YES WE CAN :D\n";
			
		}
		else
		{
			throw new \Exception("You must specify a controller name.");
		}
	}

	public function model($params)
	{

	}

	private function template_replace($template, $map)
	{
		$path = path('bundle').'bob/templates/';
		$template = file_get_contents($path.$template);

		foreach($map as $key => $val)
		{
			$template = str_replace('%%'.$key.'%%', $val, $template);
		}

		return $template;
	}
}
