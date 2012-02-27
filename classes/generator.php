<?php

class Generator
{
	private $bundle;
	private $bundle_path;
	private $standard;
	private $lower;
	private $class;
	private $class_prefix = '';
	private $class_path = '';
	private $arguments;

	public function __construct($args)
	{
		// if we got an argument
		if(isset($args[0]))
		{
			// check to see if its bundle prefixed
			if(strstr($args[0], '::'))
			{
				$parts = explode('::', $args[0]);

				// if we have a bundle and a class
				if((count($parts) == 2) && $parts[0] !== '')
				{
					$this->bundle = Str::lower($parts[0]);
					$this->bundle_path = Bundle::path($this->bundle);

					// remove the bundle section, we are done with that
					$args[0] = $parts[1];
				}
			}

			// if we have a multi-level path
			if(strstr($args[0], '.'))
			{
				$parts = explode('.', $args[0]);

				// form the class prefix as in Folder_Folder_Folder_
				$this->class_prefix = Str::classify(implode('_', array_slice($parts,0, -1)).'_');

				// form the path to the class
				$this->class_path = implode('/', array_slice($parts,0, -1)).'/';

				// unaltered case class
				$this->standard = $parts[count($parts) -1];

				// lowercase class
				$this->lower = Str::lower($parts[count($parts) -1]);

				// get our class name
				$this->class = Str::classify($parts[count($parts) -1]);
			}
			else
			{
				// unaltered case class
				$this->standard = $args[0];

				// lowercase class
				$this->lower = Str::lower($args[0]);

				// get our class name
				$this->class = Str::classify($args[0]);


			}
		}


		print_r($this);
	}
}
