<?php

/**
 * Generate a controller, its actions and associated views.
 *
 * @package 	bob
 * @author 		Dayle Rees
 * @copyright 	Dayle Rees 2012
 * @license 	MIT License <http://www.opensource.org/licenses/mit>
 */
class Generators_Controller extends Generator
{
	/**
	 * The view file extension, can also be blade.php
	 *
	 * @var string
	 */
	private $_view_extension = EXT;

	/**
	 * Start the generation process.
	 *
	 * @return void
	 */
	public function __construct($args)
	{
		parent::__construct($args);

		// we need a controller name
		if ($this->class == null)
			Common::error('You must specify a controller name.');

		// set switches
		$this->_settings();

		// start the generation
		$this->_controller_generation();

		// write filesystem changes
		$this->writer->write();
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
		$prefix = ($this->bundle == DEFAULT_BUNDLE) ? '' : Str::classify($this->bundle).'_';
		$view_prefix = ($this->bundle == DEFAULT_BUNDLE) ? '' : $this->bundle.'::';

		// set up the markers for replacement within source
		$markers = array(
			'#CLASS#'		=> $prefix.$this->class_prefix.$this->class,
			'#LOWER#'		=> $this->lower,
			'#LOWERFULL#'	=> $view_prefix.Str::lower(str_replace('/','.', $this->class_path).$this->lower)
		);

		// loud our controller template
		$template = Common::load_template('controller/controller.tpl');

		// holder for actions source, and base templates for actions and views
		$actions_source 	= '';
		$action_template 	= Common::load_template('controller/action.tpl');
		$view_template 		= Common::load_template('controller/view.tpl');

		array_unshift($this->arguments, 'index');

		// loop through our actions
		foreach ($this->arguments as $action)
		{
			// add the current action to the markers
			$markers['#ACTION#'] = Str::lower($action);

			// append the replaces source
			$actions_source .= Common::replace_markers($markers, $action_template);

			// add the file to be created
			$this->writer->create_file(
				'View',
				$this->class_path.$this->lower.'/'.Str::lower($action).$this->_view_extension,
				$this->bundle_path.'views/'.$this->class_path.$this->lower.'/'.Str::lower($action).$this->_view_extension,
				Common::replace_markers($markers, $view_template)
			);
		}

		// add a marker to replace the actions stub in the controller
		// template
		$markers['#ACTIONS#'] = $actions_source;

		// added the file to be created
		$this->writer->create_file(
			'Controller',
			$markers['#CLASS#'].'_Controller',
			$this->bundle_path.'controllers/'.$this->class_path.$this->lower.EXT,
			Common::replace_markers($markers, $template)
		);
	}

	/**
	 * Alter generation settings from artisan
	 * switches.
	 *
	 * @return void
	 */
	private function _settings()
	{
		if(Common::config('blade')) $this->_view_extension = BLADE_EXT;
	}
}
