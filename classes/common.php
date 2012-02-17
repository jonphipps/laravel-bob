<?php

/**
 * Common is a utility class for the bob
 * generation system.
 *
 * @package bob
 * @author Dayle Rees
 * @copyright Dayle Rees 2012
 */
class Common
{
	/**
	 * Log a message to the CLI with a \r\n
	 *
	 * @param $message string The message to display.
	 * @return void
	 */
	public static function log($message)
	{
		echo $message . PHP_EOL;
	}

	/**
	 * Show an error message to the CLI in the form
	 * of an exception.
	 */
	public static function error($message)
	{
		throw new \Exception($message . PHP_EOL);
	}

	/**
	 * Load the source from a template file and return it
	 * as a string.
	 *
	 * @param $template_name string The file name of the template.
	 * @return string The template content.
	 */
	public static function load_template($template_name)
	{
		// first look in the project templates this way
		// the user can have project-specific templating
		if(File::exists($source = Config::get('bob::options.project_templates').$template_name))
		{
			return File::get($source);
		}
		elseif(File::exists($source = Config::get('bob::options.template_path').$template_name))
		{
			return File::get($source);
		}
		else
		{
			static::error('A generation template could not be found for this object.');
		}
	}

	/**
	 * Use a key-value array to replace markers within
	 * a source template with their appropriate value.
	 *
	 * @param $markers array Markers to value array.
	 * @param $template string The source containing markers.
	 * @return string The processed template with values inserted.
	 */
	public static function replace_markers($markers, $template)
	{
		// the array key hold the marker (#NAME#) which
		// is globaly replaced with the array value
		foreach ($markers as $marker => $value)
		{
			$template = str_replace($marker, $value, $template);
		}

		return $template;
	}

	/**
	 * Iterate through a files array, creating files in
	 * different locations where neccessary.
	 *
	 * <code>
	 * $files[] = array(
	 * 		'type' 		=> 'View',
	 *   	'name' 		=> 'Descriptive identifier shown to terminal.',
	 *    	'location' 	=> 'location/to/save/the/file.php',
	 *     	'content' 	=> 'the string content of the file'
	 * );
	 * </code>
	 *
	 * @param array The files array.
	 * @return void
	 */
	public static function save($files)
	{
		/** TODO sort array by type uasort() with cb */

		// for each file in the files array
		foreach($files as $file)
		{
			// force the directory creation
			@mkdir(dirname($file['location']) , 0777, true);

			if(@File::exists($file['location']))
			{
				static::log('(~) '.$file['type']."\t\t".$file['name'].' (Exists - Skipped)');
				continue;
			}
			// try to create the file
			if(@File::put($file['location'], $file['content']))
			{
				// log something pretty to the terminal
				static::log('(+) '.$file['type']."\t\t".$file['name']);
			}
			else
			{
				static::error('Could not write to location : ' .$file['location']);
			}
		}

		static::log('--ALL-DONE!-----------------------------------');
	}
}
