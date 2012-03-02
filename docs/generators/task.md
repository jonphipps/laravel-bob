---
layout: default
title: Tasks
fork-path: https://github.com/daylerees
---

#Tasks

##Usage
To generate an artisan task with methods, use the following command :

	bob task [args] <task_name> [methods ...]

<div class="alert alert-info">
<strong>Note :</strong> You can use the shortcut <strong>bob ta</strong> instead of <strong>bob task</strong> to save characters.
</div>


##Arguments

None.

##Example

	bob task microwave ping beep

produces :

{% highlight php startinline %}
<?php

class Microwave_Task extends Task {

	public function run($arguments)
	{
		echo "Ran task: Microwave_Task : run()".PHP_EOL;
	}

	public function ping()
	{
		echo "Ran task: Microwave_Task : ping()".PHP_EOL;
	}

	public function beep()
	{
		echo "Ran task: Microwave_Task : beep()".PHP_EOL;
	}

}
{% endhighlight %}