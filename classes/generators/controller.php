<?php

/**
 * Generate a new controller class, including actions
 * and views for each action.
 *
 * @package bob
 * @author Dayle Rees
 * @copyright Dayle Rees 2012
 */
class Generators_Controller
{
	// the name of the controller and an array of actions
	private static $_controller_name;
	private static $_controller_actions;

	// the view extension and bundle name/path
	private static $_view_extension = EXT;
	private static $_bundle;
	private static $_bundle_path;

	// array of files to write when generating
	private static $_files = array();


	/**
	 * Start the generation process.
	 *
	 * @param $params array Words supplied to the controller command.
	 * @return void
	 */
	public static function go($params = array())
	{
		// we need a controller name
		if (! count($params))
			Common::error('You must specify a controller name.');

		// attempt to get the bundle name, defaults to application
		static::$_bundle = Bundle::name(Str::lower($params[0]));

		// make sure it exists
		if (! Bundle::exists(static::$_bundle))
			Common::error("The specified bundle does not exist.\nRemember to add your bundle to bundles.php");

		// if its not the default bundle, we need to use the bundles dir
		static::$_bundle_path = (static::$_bundle == DEFAULT_BUNDLE)
				? path('app') : path('bundle').static::$_bundle;

		// get the controller name from the first argument
		static::$_controller_name = Bundle::element(Str::lower($params[0]));

		// slice out extra words as command params
		static::$_controller_actions = array_slice($params, 1);

		// start the generation
		static::_controller_generation();

		// save the resulting array
		Common::save(static::$_files);
	}

	/**
	 * This method is responsible for generation all
	 * source from the templates, and populating the
	 * files array.
	 *
	 * @return  void
	 */
	private static function _controller_generation()
	{
		// prefix with bundle, if not in application
		$class = (static::$_bundle !== DEFAULT_BUNDLE) ? Str::classify(static::$_bundle).'_' : '';

		// set up the markers for replacement within source
		$markers = array(
			'#CLASS#'		=> $class.Str::classify(static::$_controller_name),
			'#LOWER#'		=> self::$_controller_name
		);

		// loud our controller template
		$template = Common::load_template('controller/controller.tpl');

		// holder for actions source, and base templates for actions and views
		$actions_source 	= '';
		$action_template 	= Common::load_template('controller/action.tpl');
		$view_template 		= Common::load_template('controller/view.tpl');

		// loop through our actions
		foreach (static::$_controller_actions as $action)
		{
			// add the current action to the markers
			$markers['#ACTION#'] = Str::lower($action);

			// append the replaces source
			$actions_source .= Common::replace_markers($markers, $action_template);

			// add a replaced view to the files array
			$view = array(
				'type'		=> 'View',
				'name'		=> $markers['#LOWER#'].'/'.$markers['#ACTION#'].static::$_view_extension,
				'location'	=> static::$_bundle_path.'/views/'.$markers['#LOWER#'].'/'.$markers['#ACTION#'].static::$_view_extension,
				'content'	=> Common::replace_markers($markers, $view_template)
			);

			static::$_files[] = $view;
		}

		// add a marker to replace the actions stub in the controller
		// template
		$markers['#ACTIONS#'] = $actions_source;

		// add the replace controller to the files array
		$controller = array(
			'type'		=> 'Controller',
			'name'		=> $markers['#CLASS#'].'_Controller',
			'location'	=> static::$_bundle_path.'/controllers/'.$markers['#LOWER#'].EXT,
			'content'	=> Common::replace_markers($markers, $template)
		);

		static::$_files[] = $controller;
	}
}
