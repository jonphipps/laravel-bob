---
layout: default
title: Configs
fork-path: https://github.com/daylerees
---

#Configs

##Usage
To generate a config file :

	bob config [args] <config_name> [options ...]

<div class="alert alert-info">
<strong>Note :</strong> You can use the shortcut <strong>bob co</strong> instead of <strong>bob config</strong> to save characters.
</div>

##Arguments

None.

##Example

	bob config screen height width

produces :

{% highlight php startinline %}
<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| height
	|--------------------------------------------------------------------------
	|
	| Here you describe the config option in detail.
	|
	*/

	'height' 	=> true,

	/*
	|--------------------------------------------------------------------------
	| width
	|--------------------------------------------------------------------------
	|
	| Here you describe the config option in detail.
	|
	*/

	'width' 	=> true,

);
{% endhighlight %}