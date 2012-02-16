<?php

use Laravel\Str;

/**
 * Common functions for dealing with templates.
 *
 * @author  Dayle Rees.
 * @copyright  Dayle Rees 2012.
 * @package  bob
 */
class EloquentGenerator
{
	// holds params passed to artisan
	private $params = array();

	private $_belongs_to = array();
	private $_has_many = array();
	private $_has_one = array();
	private $_has_and_belongs_to_many = array();

	private $_timestamps = false;

	/**
	* Check for params and start the creation process.
	*/
	public function __construct($params)
	{
		// we need at least one param
		if (! count($params))
			throw new \Exception('You must specify a model name.');

		// get settings from CLI
		$this->_settings();

		$this->params = $params;

		$this->_get_relations();

		// fire off the creation methods
		$this->_create_model();
	}

	private function _get_relations()
	{
		$extra = array_slice($this->params, 1);

		foreach ($extra as $e)
		{
			if(strstr($e, ':'))
			{
				$parts = explode(':', $e);

				if(count($parts) > 1)
				{
					switch($parts[0])
					{
						case "belongs_to":
							$this->_belongs_to[] = $parts[1];
							break;
						case "bt":
							$this->_belongs_to[] = $parts[1];
							break;
						case "has_many":
							$this->_has_many[] = $parts[1];
							break;
						case "hm":
							$this->_has_many[] = $parts[1];
							break;
						case "has_one":
							$this->_has_one[] = $parts[1];
							break;
						case "ho":
							$this->_has_one[] = $parts[1];
							break;
						case "has_and_belongs_to_many":
							$this->_has_and_belongs_to_many[] = $parts[1];
							break;
						case "hbm":
							$this->_has_and_belongs_to_many[] = $parts[1];
							break;
					}
				}
			}
		}
	}


	private function _create_model()
	{
		$timestamp = ($this->_timestamps) ? "\tpublic static \$timestamps = true;" : '';

		// markers for replacement
		$markers = array(
			'#CLASS#' => Str::classify($this->params[0]),
			'#LOWER#' => Str::lower($this->params[0]),
			'#TIMESTAMPS#' => $timestamp
		);

		$relations = '';

		foreach ($this->_belongs_to as $rel)
		{
			$rel_markers = array(
				'#SINGULAR#' 	=> Str::lower($rel),
				'#PLURAL#'		=> Str::plural($rel),
				'#WORD#'		=> Str::classify($rel)
			);

			$template = Common::get_template('belongs_to.tpl');
			$relations .= Common::replace_markers($rel_markers, $template);
		}

		foreach ($this->_has_many as $rel)
		{
			$rel_markers = array(
				'#SINGULAR#' 	=> Str::lower($rel),
				'#PLURAL#'		=> Str::plural($rel),
				'#WORD#'		=> Str::classify($rel)
			);

			$template = Common::get_template('has_many.tpl');
			$relations .= Common::replace_markers($rel_markers, $template);
		}

		foreach ($this->_has_one as $rel)
		{
			$rel_markers = array(
				'#SINGULAR#' 	=> Str::lower($rel),
				'#PLURAL#'		=> Str::plural($rel),
				'#WORD#'		=> Str::classify($rel)
			);

			$template = Common::get_template('has_one.tpl');
			$relations .= Common::replace_markers($rel_markers, $template);
		}

		foreach ($this->_has_and_belongs_to_many as $rel)
		{
			$rel_markers = array(
				'#SINGULAR#' 	=> Str::lower($rel),
				'#PLURAL#'		=> Str::plural($rel),
				'#WORD#'		=> Str::classify($rel)
			);

			$template = Common::get_template('has_and_belongs_to_many.tpl');
			$relations .= Common::replace_markers($rel_markers, $template);
		}

		if ($this->_timestamps) $relations = "\n\n".$relations;

		$markers['#RELATIONS#'] = $relations;

		// get the controller template and replace markers
		$template = Common::get_template('eloquent.tpl');
		$model_source = Common::replace_markers($markers, $template);








		// save the controller, and log its creation
		Common::save(path('app').'models/'.$markers['#LOWER#'].EXT, $model_source);
		Common::created('Model', $markers['#CLASS#']);
	}


	/**
	 * Set class attributes for CLI switches.
	 */
	private function _settings()
	{
		if (isset($_SERVER['CLI']['TIMESTAMPS'])) $this->_timestamps = true;
		if (isset($_SERVER['CLI']['TS'])) $this->_timestamps = true;
	}
}
