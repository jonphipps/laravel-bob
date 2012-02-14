<?php

use Laravel\Str;

class ControllerGenerator
{
	private $params = array();

	private $_use_blade = false;

	public function __construct($params)
	{
		if (! count($params))
			throw new \Exception('You must specify a controller name.');

		$this->_settings();

		$this->params = $params;

		$this->_create_controller();
		$this->_create_views();
	}

	private function _create_controller()
	{
		$markers = array(
			'#CLASS#' => Str::classify($this->params[0]),
			'#LOWER#' => Str::lower($this->params[0])
		);

		$template = Common::get_template('controller.tpl');
		$controller_source = Common::replace_markers($markers, $template);

		$actions = array_slice($this->params, 1);
		$actions_source = '';
		$template = Common::get_template('action.tpl');

		foreach ($actions as $action)
		{
			$markers['#ACTION#'] = Str::lower($action);
			$actions_source .= Common::replace_markers($markers, $template);
		}

		$markers['#ACTIONS#'] = $actions_source;

		$controller_source = Common::replace_markers($markers, $controller_source);

		Common::save(path('app').'controllers/'.$markers['#LOWER#'].EXT, $controller_source);
		Common::created('Controller', $markers['#CLASS#'].'_Controller');
	}

	private function _create_views()
	{


		$markers = array(
			'#CLASS#' => Str::classify($this->params[0]),
			'#LOWER#' => Str::lower($this->params[0])
		);

		$actions = array_slice($this->params, 1);
		$view_source = Common::get_template('view.tpl');

		foreach ($actions as $action)
		{
			$markers['#ACTION#'] = Str::lower($action);
			$view = Common::replace_markers($markers, $view_source);

			Common::save(path('app').'views/'.$markers['#LOWER#']. '/'. $markers['#ACTION#'] .EXT, $view);
			Common::created('View', $markers['#LOWER#'] .'.'. $markers['#ACTION#']);
		}

	}

	private function _settings()
	{
		if (isset($_SERVER['CLI']['BLADE'])) $this->_use_blade = true;
	}
}
