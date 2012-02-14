<?php

include __DIR__.'/generators/controller.php';

/**
 * Common functions for dealing with templates.
 *
 * @author  Dayle Rees.
 * @copyright  Dayle Rees 2012.
 * @package  bob
 */
class Common
{
	/**
	 * Save a string to a new file.
	 *
	 * @param $file string The path to the file.
	 * @param $content string The file contents.
	 */
	public static function save($file, $content)
	{
		// make the directory, recursively
		@mkdir(dirname($file) , 0777, true);

		// attempt to write, alert on permissions error
		if (file_put_contents($file, $content) === false)
		{
			throw new \Exception('Unable to write to destination, check permissions!');
		}
	}

	/**
	 * Get the template source, from either the bob dir or templates.
	 *
	 * @param $template_name string The file name, including .tpl
	 * @return string The template as a string.
	 */
	public static function get_template($template_name)
	{
		// check if the file exists in application/bob/ load it from there first
		if(file_exists(path('app').'bob/'.$template_name))
		{
			if($source = file_get_contents(path('app').'bob/'.$template_name))
			{
				return $source;
			}
			else
			{
				throw new \Exception('Could not read user templates, check permissions!');
			}
		}
		else // otherwise load the source from the default templates dir
		{
			if($source = file_get_contents(__DIR__.'/templates/'.$template_name))
			{
				return $source;
			}
			else
			{
				throw new \Exception('Could not load templates, check permissions!');
			}
		}
	}

	/**
	 * Replace template markers using a key value array.
	 *
	 * @param $markers array An array of markers and their values.
	 * @param $template string The source template in string format.
	 * @return string The resulting source code.
	 */
	public static function replace_markers($markers, $template)
	{
		// replace markers with values
		foreach ($markers as $marker => $value)
		{
			$template = str_replace($marker, $value, $template);
		}

		return $template;
	}

	public static function created($type, $name)
	{
		echo '(+) ' . $type . "\t\t- " . $name . "\n";
	}
}
