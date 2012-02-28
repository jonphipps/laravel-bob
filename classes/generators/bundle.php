<?php

/**
 * Generate a new controller class, including actions
 * and views for each action.
 *
 * @package bob
 * @author Dayle Rees
 * @copyright Dayle Rees 2012
 */
class Generators_Bundle extends Generator
{
	/**
	 * Start the generation process.
	 *
	 * @return void
	 */
	public function generate()
	{
		// we need a controller name
		if ($this->lower == null)
			Common::error('You must specify a bundle name.');

		// dirs to move
		$dirs[] = array(
			'type'			=> 'Bundle',
			'name'			=> $this->lower,
			'source'		=> Bundle::path('bob').'templates/bundle', /** TODO add override path */
			'destination'	=> path('bundle').$this->lower
		);

		// move the new template
		Common::move_template($dirs);
	}
}
