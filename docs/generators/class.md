---
layout: default
title: Classes
fork-path: https://github.com/daylerees
---

#Classes

##Usage
To generate a generic class with methods :

	bob class [args] <class_name> [methods ...]

<div class="alert alert-info">
<strong>Note :</strong> You can use the shortcut <strong>bob cl</strong> instead of <strong>bob class</strong> to save characters.
</div>

##Arguments

None.

##Example

	bob class spoon fork knife

produces :

{% highlight php startinline %}
<?php

class Spoon {

	public function __construct()
	{
		// init code here..
	}

	public function fork()
	{
		// code here..
	}

	public function knife()
	{
		// code here..
	}

}

{% endhighlight %}