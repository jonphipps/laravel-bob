<?php

/**
 * Generate a new controller class, including actions
 * and views for each action.
 *
 * @package bob
 * @author Dayle Rees
 * @copyright Dayle Rees 2012
 */
class Generators_Bundle
{
	/**
	 * The name of the new bundle.
	 *
	 * @var string
	 */
	private static $_bundle;

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
			Common::error('You must specify a bundle name.');

		// attempt to get the bundle name, defaults to application
		static::$_bundle = Str::lower($params[0]);

		// dirs to move
		$dirs[] = array(
			'type'			=> 'Bundle',
			'name'			=> static::$_bundle,
			'source'		=> Bundle::path('bob').'templates/bundle',
			'destination'	=> path('bundle').static::$_bundle
		);

		// move the new template
		Common::move_template($dirs);
	}	
}