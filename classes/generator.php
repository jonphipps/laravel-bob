<?php

class Generator
{
	protected $args;
	protected $bundle;
	protected $bundle_path;
	protected $standard;
	protected $lower;
	protected $class;
	protected $class_prefix = '';
	protected $class_path = '';
	protected $arguments;

	public function __construct($args)
	{
		$this->args = $args;

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

					if(! Bundle::exists($this->bundle))
						Common::error('The specified bundle does not exist, or is not loaded.');

					// remove the bundle section, we are done with that
					$args[0] = $parts[1];
				}
			}
			else
			{
				$this->bundle = DEFAULT_BUNDLE;
			}

			$this->bundle_path = Bundle::path($this->bundle);

			// if we have a multi-level path
			if(strstr($args[0], '.'))
			{
				$parts = explode('.', $args[0]);

				// form the class prefix as in Folder_Folder_Folder_
				$this->class_prefix = Str::classify(implode('_', array_slice($parts,0, -1)).'_');

				// form the path to the class
				$this->class_path = Str::lower(implode('/', array_slice($parts,0, -1)).'/');

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

		$this->arguments = array_slice($args, 1);


		print_r($this);
	}
}
