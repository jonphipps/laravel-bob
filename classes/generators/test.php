<?php

/**
 * Generate a new controller class, including actions
 * and views for each action.
 *
 * @package bob
 * @author Dayle Rees
 * @copyright Dayle Rees 2012
 */
class Generators_Test
{
	/**
	 * The name of the test case, from task parameters.
	 *
	 * @var string
	 */
	private static $_test_case;

	/**
	 * The individual tests, specified as additional "words".
	 *
	 * @var array
	 */
	private static $_tests;

	/**
	 * The name of the bundle.
	 *
	 * @var string
	 */
	private static $_bundle;

	/**
	 * The path to the bundle.
	 *
	 * @var string
	 */
	private static $_bundle_path;

	/**
	 * An array of files to write after generation.
	 *
	 * @var array
	 */
	private static $_files = array();


	/**
	 * Start the generation process.
	 *
	 * @param $params array Words supplied to the task command.
	 * @return void
	 */
	public static function go($params = array())
	{
		// we need a task name
		if (! count($params))
			Common::error('You must specify a task name.');

		// attempt to get the bundle name, defaults to application
		static::$_bundle = Bundle::name(Str::lower($params[0]));

		// make sure it exists
		if (! Bundle::exists(static::$_bundle))
			Common::error("The specified bundle does not exist.\nRemember to add your bundle to bundles.php");

		// if its not the default bundle, we need to use the bundles dir
		static::$_bundle_path = (static::$_bundle == DEFAULT_BUNDLE)
				? path('app') : path('bundle').static::$_bundle;

		// get the test case name from the first argument
		if(strstr($params[0], '::'))
		{
			$parts = explode('::', $params[0]);

			if(count($parts) == 2)
			{
				static::$_test_case = $parts[1];
			}
			else
			{
				static::$_test_case = $params[0];
			}
		}
		else
		{
			static::$_test_case = $params[0];
		}
		

		// slice out extra words as command params
		static::$_tests = array_slice($params, 1);		

		// load any command line switches
		static::_settings();

		// start the generation
		static::_test_generation();

		// save the resulting array
		Common::save(static::$_files);
	}

	/**
	 * This method is responsible for generation all
	 * source from the templates, and populating the
	 * files array.
	 *
	 * @return void
	 */
	private static function _test_generation()
	{
		// prefix with bundle, if not in application
		$class = (static::$_bundle !== DEFAULT_BUNDLE) ? Str::classify(static::$_bundle).'_' : '';

		// set up the markers for replacement within source
		$markers = array(
			'#CLASS#'		=> $class.static::$_test_case
		);

		// loud our test case template
		$template = Common::load_template('test/test_case.tpl');

		// holder for tasks source, and base templates for tasks
		$tasks_source 	= '';
		$task_template 	= Common::load_template('test/test.tpl');

		// loop through our tests
		foreach (static::$_tests as $test)
		{
			// add the current task to the markers
			$markers['#NAME#'] = $test;

			// append the replaced source
			$tasks_source .= Common::replace_markers($markers, $task_template);
		}

		// add a marker to replace the test stub in the test case
		// template
		$markers['#TESTS#'] = $tasks_source;

		// add the replaced test case to the files array
		$test_case = array(
			'type'		=> 'Task',
			'name'		=> 'Test'.$markers['#CLASS#'],
			'location'	=> static::$_bundle_path.'/tests/'.Str::lower($markers['#CLASS#']).'.test'.EXT,
			'content'	=> Common::replace_markers($markers, $template)
		);

		static::$_files[] = $test_case;
	}

	/**
	 * Alter generation settings from artisan
	 * switches.
	 *
	 * @return void
	 */
	private static function _settings()
	{

	}
}
