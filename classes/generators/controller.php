<?php

class Generators_Controller extends Generator
{

	/**
	 * The view file extension, can also be blade.php
	 *
	 * @var string
	 */
	private $_view_extension = EXT;

	/**
	 * An array of files to write after generation.
	 *
	 * @var array
	 */
	private $_files = array();


	/**
	 * Start the generation process.
	 *
	 * @return void
	 */
	public function generate()
	{
		// we need a controller name
		if ($this->class == null)
			Common::error('You must specify a controller name.');

		// load any command line switches
		$this->_settings();

		// start the generation
		$this->_controller_generation();

		// save the resulting array
		Common::save($this->_files);
	}

	/**
	 * This method is responsible for generation all
	 * source from the templates, and populating the
	 * files array.
	 *
	 * @return void
	 */
	private function _controller_generation()
	{
		// set up the markers for replacement within source
		$markers = array(
			'#CLASS#'		=> $this->class_prefix.$this->class,
			'#LOWER#'		=> $this->lower,
			'#LOWERFULL#'	=> Str::lower(str_replace('/','.', $this->class_path).$this->lower)
		);

		// loud our controller template
		$template = Common::load_template('controller/controller.tpl');

		// holder for actions source, and base templates for actions and views
		$actions_source 	= '';
		$action_template 	= Common::load_template('controller/action.tpl');
		$view_template 		= Common::load_template('controller/view.tpl');

		// loop through our actions
		foreach ($this->arguments as $action)
		{
			// add the current action to the markers
			$markers['#ACTION#'] = Str::lower($action);

			// append the replaces source
			$actions_source .= Common::replace_markers($markers, $action_template);

			// add a replaced view to the files array
			$view = array(
				'type'		=> 'View',
				'name'		=> $this->class_path.$this->lower.'/'.Str::lower($action).$this->_view_extension,
				'location'	=> $this->bundle_path.'/views/'.$this->class_path.$this->lower.'/'.Str::lower($action).$this->_view_extension,
				'content'	=> Common::replace_markers($markers, $view_template)
			);

			$this->_files[] = $view;
		}

		// add a marker to replace the actions stub in the controller
		// template
		$markers['#ACTIONS#'] = $actions_source;

		// add the replace controller to the files array
		$controller = array(
			'type'		=> 'Controller',
			'name'		=> $markers['#CLASS#'].'_Controller',
			'location'	=> $this->bundle_path.'/controllers/'.$this->class_path.$this->lower.EXT,
			'content'	=> Common::replace_markers($markers, $template)
		);

		$this->_files[] = $controller;
	}

	/**
	 * Alter generation settings from artisan
	 * switches.
	 *
	 * @return void
	 */
	private function _settings()
	{
		if(isset($_SERVER['CLI']['BLADE'])) $this->_view_extension = BLADE_EXT;
	}
}
