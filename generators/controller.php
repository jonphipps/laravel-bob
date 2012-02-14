<?php

use Laravel\Str;

/**
 * Common functions for dealing with templates.
 *
 * @author  Dayle Rees.
 * @copyright  Dayle Rees 2012.
 * @package  bob
 */
class ControllerGenerator
{
	// holds params passed to artisan
	private $params = array();

	// use blade format for views?
	private $_use_blade = false;

	/**
	* Check for params and start the creation process.
	*/
	public function __construct($params)
	{
		// we need at least one param
		if (! count($params))
			throw new \Exception('You must specify a controller name.');

		// get settings from CLI
		$this->_settings();

		$this->params = $params;

		// fire off the creation methods
		$this->_create_controller();
		$this->_create_views();
	}

	/**
	 * Create the controller and its actions.
	 */
	private function _create_controller()
	{
		// markers for replacement
		$markers = array(
			'#CLASS#' => Str::classify($this->params[0]),
			'#LOWER#' => Str::lower($this->params[0])
		);

		// get the controller template and replace markers
		$template = Common::get_template('controller.tpl');
		$controller_source = Common::replace_markers($markers, $template);

		// slice the array to show actions, get the action template
		$actions = array_slice($this->params, 1);
		$actions_source = '';
		$template = Common::get_template('action.tpl');

		// loop through actions replacing markers, creating actions string
		foreach ($actions as $action)
		{
			$markers['#ACTION#'] = Str::lower($action);
			$actions_source .= Common::replace_markers($markers, $template);
		}

		// add a new marker, so we can replace in the controller
		$markers['#ACTIONS#'] = $actions_source;

		// do the switcheroo
		$controller_source = Common::replace_markers($markers, $controller_source);

		// save the controller, and log its creation
		Common::save(path('app').'controllers/'.$markers['#LOWER#'].EXT, $controller_source);
		Common::created('Controller', $markers['#CLASS#'].'_Controller');
	}

	/**
	 * Create a view for each generated action.
	 */
	private function _create_views()
	{
		// replacement markers
		$markers = array(
			'#CLASS#' => Str::classify($this->params[0]),
			'#LOWER#' => Str::lower($this->params[0])
		);

		// get actions
		$actions = array_slice($this->params, 1);
		$view_source = Common::get_template('view.tpl');

		foreach ($actions as $action)
		{
			// update the markers and get the view source
			$markers['#ACTION#'] = Str::lower($action);
			$view = Common::replace_markers($markers, $view_source);

			// different extension if we are using blade
			if ($this->_use_blade)
			{
				Common::save(path('app').'views/'.$markers['#LOWER#']. '/'. $markers['#ACTION#'].'.blade' .EXT, $view);
				Common::created('View', $markers['#LOWER#'] .'.'. $markers['#ACTION#'] . ' [blade]');
			}
			else
			{
				Common::save(path('app').'views/'.$markers['#LOWER#']. '/'. $markers['#ACTION#'] .EXT, $view);
				Common::created('View', $markers['#LOWER#'] .'.'. $markers['#ACTION#']);
			}
		}

	}

	/**
	 * Set class attributes for CLI switches.
	 */
	private function _settings()
	{
		if (isset($_SERVER['CLI']['BLADE'])) $this->_use_blade = true;
	}
}
