<?php

/**
 * Generate a new eloquent model, including
 * relationships.
 *
 * @package bob
 * @author Dayle Rees
 * @copyright Dayle Rees 2012
 */
class Generators_Model
{
	/**
	 * The name of the model, from task parameters.
	 *
	 * @var string
	 */
	private static $_model_name;

	/**
	 * The model relationships, specified as additional "words".
	 *
	 * @var array
	 */
	private static $_relationships;

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
	 * Enable the timestamps string in models?
	 *
	 * @var string
	 */
	private static $_timestamps = '';

	/**
	 * An array of files to write after generation.
	 *
	 * @var array
	 */
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
			Common::error('You must specify a model name.');

		// attempt to get the bundle name, defaults to application
		static::$_bundle = Bundle::name(Str::lower($params[0]));

		// make sure it exists
		if (! Bundle::exists(static::$_bundle))
			Common::error("The specified bundle does not exist.\nRemember to add your bundle to bundles.php");

		// if its not the default bundle, we need to use the bundles dir
		static::$_bundle_path = (static::$_bundle == DEFAULT_BUNDLE)
				? path('app') : path('bundle').static::$_bundle;

		// get the model name from the first argument
		static::$_model_name = Bundle::element(Str::lower($params[0]));

		// slice out extra words as command params
		static::$_relationships = array_slice($params, 1);

		// load any command line switches
		static::_settings();

		// start the generation
		static::_model_generation();

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
	private static function _model_generation()
	{
		// prefix with bundle, if not in application
		$class = (static::$_bundle !== DEFAULT_BUNDLE) ? Str::classify(static::$_bundle).'_' : '';

		// set up the markers for replacement within source
		$markers = array(
			'#CLASS#'		=> $class.Str::classify(static::$_model_name),
			'#LOWER#'		=> Str::lower(static::$_model_name),
			'#TIMESTAMPS#'	=> static::$_timestamps
		);

		// loud our model template
		$template = Common::load_template('model/model.tpl');

		// holder for relationships source
		$relationships_source = '';

		// loop through our relationships
		foreach (static::$_relationships as $relation)
		{
			// if we have a valid relation
			if(! strstr($relation, ':')) continue;

			// split
			$relation_parts = explode(':', Str::lower($relation));

			// we need two parts
			if(! count($relation_parts) == 2) continue;

			// markers for relationships
			$rel_markers = array(
				'#SINGULAR#'		=> Str::lower(Str::singular($relation_parts[1])),
				'#PLURAL#'			=> Str::lower(Str::plural($relation_parts[1])),
				'#WORD#'			=> Str::classify(Str::singular($relation_parts[1])),
				'#WORDS#'			=> Str::classify(Str::plural($relation_parts[1]))
			);

			// start with blank
			$relationship_template = '';

			// use switch to decide which template
			switch ($relation_parts[0])
			{
				case "has_many":
				case "hm":
					$relationship_template = Common::load_template('model/has_many.tpl');
					break;
				case "belongs_to":
				case "bt":
					$relationship_template = Common::load_template('model/belongs_to.tpl');
					break;
				case "has_one":
				case "ho":
					$relationship_template = Common::load_template('model/has_one.tpl');
					break;
				case "has_and_belongs_to_many":
				case "hbm":
					$relationship_template = Common::load_template('model/has_and_belongs_to_many.tpl');
					break;
			}

			// add it to the source
			$relationships_source .= Common::replace_markers($rel_markers, $relationship_template);
		}

		// add a marker to replace the relationships stub
		// in the model template
		$markers['#RELATIONS#'] = $relationships_source;

		// add the replaced model to the files array
		$model = array(
			'type'		=> 'Model',
			'name'		=> $markers['#CLASS#'],
			'location'	=> static::$_bundle_path.'/models/'.$markers['#LOWER#'].EXT,
			'content'	=> Common::replace_markers($markers, $template)
		);

		// store the file ready for saving
		static::$_files[] = $model;
	}

	/**
	 * Alter generation settings from artisan
	 * switches.
	 *
	 * @return void
	 */
	private static function _settings()
	{
		if(isset($_SERVER['CLI']['TIMESTAMPS']))
			static::$_timestamps = "\tpublic static \$timestamps = true;\n\n";
		if(isset($_SERVER['CLI']['TS']))
			static::$_timestamps = "\tpublic static \$timestamps = true;\n\n";
	}
}
