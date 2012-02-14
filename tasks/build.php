<?php

use Laravel\CLI\Tasks\Task;
use Laravel\Str;

/**
 * Bob, the scaffolder.
 *
 * Generate source files for the Laravel framework.
 * Thanks to Phillsparks for the name!
 *
 * @copyright  Dayle Rees (c) 2012
 * @author  Dayle Rees.
 * @package  bob
 */
class Bob_Build_Task extends Task
{
	private $_use_blade = false;

	/**
	 * Generate a new controller, and optionaly actions.
	 *
	 * @param $params array First index is controller name, others actions.
	 */
	public function controller($params)
	{
		// if we don't have at least one param we can't do anything!
		if (! count($params)) throw new \Exception('Need controller name.');

		$this->_options($params);

		// set the mappings to match the template file
		$controller['name'] 	= $params[0];
		$controller['class'] 	= Str::classify($params[0]);
		$controller['lower'] 	= Str::lower($params[0]);
		$controller['method'] 	= 'index';
		$controller['multi']	= array_slice($params, 1);

		// get the template source, with mappings replaced
		$source = $this->_get_source('controller.tpl', $controller);
		$this->_new('Controller', $controller['class'] . "_Controller");
		$this->_new('Action', $controller['lower'] . "@" . $controller['method'] );
		if($this->_use_blade)
		{
			$this->_new('View', $controller['lower'] . "/" . $controller['method'] . ".blade.php");
		}
		else
		{
			$this->_new('View', $controller['lower'] . "/" . $controller['method'] . ".php");
		}


		// get the actions list
		$actions = $this->_get_source_multi('action.tpl', $controller);

		// replace it into our controller template
		$source = str_replace('%%ACTIONS%%', $actions, $source);

		// create controllers dir, the controller
		$this->_save(path('app').'controllers/'.$controller['lower'].EXT, $source);

		// now get the source for the view, identical mappings
		$source = $this->_get_source('view.tpl', $controller);

		// create the view file
		if($this->_use_blade)
		{
			$this->_save(path('app').'views/'.$controller['lower'].'/'.$controller['method'].'.blade.php', $source);
		}
		else
		{
			$this->_save(path('app').'views/'.$controller['lower'].'/'.$controller['method'].'.php', $source);
		}


		$this->_log('-- YES WE CAN :D -- ');
	}

	/**
	 * Get the template source, and swap out mapped elements.
	 *
	 * @param $template string The template file name.
	 * @param $map array A map of key=>value replacement pairs.
	 * @return string The mapped source.
	 */
	private function _get_source($template, $map)
	{
		// the path to the templates folder
		$templates = __DIR__.'/../templates/';

		// get the template source
		$parsed = file_get_contents($templates.$template);

		// for each of the mapping pairs
		foreach ($map as $key => $val)
		{
			// as long as its not the actions holder, swap them out
			if($key == 'multi') continue;
			$parsed = str_replace('%%'.Str::upper($key).'%%', $val, $parsed);
		}

		return $parsed;
	}

	/**
	 * This acts as _get_source() but instead works for actions
	 * within the 'multi' array index.
	 *
	 * @param $template string The template file name.
	 * @param $map array A map of key=>value replacement pairs.
	 * @return string The mapped source.
	 */
	private function _get_source_multi($template, $map)
	{
		// this we will pass back
		$result = '';

		// for each of the multi parts, normally actions
		foreach($map['multi'] as $multi)
		{
			// adapt the map to suit actions
			$map['name'] = Str::lower($multi);
			$map['method'] = Str::lower($multi);

			// pass the template parsing to the existing method to save DRY
			$result .= $this->_get_source($template, $map);
			$this->_new('Action', $map['lower'] . "@" . $map['method'] );

			// now get the source for the view, identical mappings
			$source = $this->_get_source('view.tpl', $map);

			// create the view file, and alert its creation
			if ($this->_use_blade)
			{
				$this->_save(path('app').'views/'.$map['lower'].'/'.$map['method'].'.blade.php', $source);
				$this->_new('View', $map['lower'] . "/" . $map['method'] . ".blade.php");
			}
			else
			{
				$this->_save(path('app').'views/'.$map['lower'].'/'.$map['method'].'.php', $source);
				$this->_new('View', $map['lower'] . "/" . $map['method'] . ".php");
			}
		}

		return $result;
	}

	/**
	 * Use file_put_contents() to save the generated source.
	 *
	 * @param $file string The path/file to save to.
	 * @param $contents string The contents of the new file.
	 */
	private function _save($file, $contents)
	{
		// make sure the dir exists, if not make it
		@mkdir(dirname($file) , 0777, true);

		// put the file, output an error on write problems
		if (file_put_contents($file, $contents) === false)
			throw new \Exception("Unable to write to destination.");
	}

	/**
	 * Log a message to the console with a newline.
	 *
	 * @param $message string The message to log to console.
	 */
	private function _log($message)
	{
		echo $message. "\n";
	}

	/**
	 * Log a creation message within a template.
	 *
	 * @param $type string The type of item created.
	 * @param $name string An identifier for the item created.
	 */
	private function _new($type, $name)
	{
		$this->_log('[+] ' . $type . "\t\t '" . $name . "'");
	}

	private function _options($params)
	{
		if(isset($_SERVER['CLI']['BLADE'])) $this->_use_blade = true;

	}
}
