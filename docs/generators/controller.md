---
layout: default
title: Controllers
fork-path: https://github.com/daylerees
---

#Controllers

To generate controllers with actions, and view files, simply pass the action names as extra arguments to the `controller` command :

	bob controller [args] <controller_name> [actions ...]

**Note :** *You can use the shortcut `bob c` instead of `bob controller` to save characters.*

For example :

	bob c mycontroller first second third

will produce :

{% highlight php startinline %}
<?php

class Mycontroller_Controller extends Base_Controller {

	public function action_index()
	{
		// code here..

		return View::make('mycontroller.index');
	}

	public function action_first()
	{
		// code here..

		return View::make('mycontroller.first');
	}

	public function action_second()
	{
		// code here..

		return View::make('mycontroller.second');
	}

	public function action_third()
	{
		// code here..

		return View::make('mycontroller.third');
	}

}
{% endhighlight %}


with the following view created for each action :

{% highlight php startinline %}
<h1>mycontroller.second</h1>

<p>This view has been auto-generated to accompany the Mycontroller_Controller's action_second()</p>
{% endhighlight %}

Use the `--blade` switch anywhere within the command to generate view files with the Blade extension (.blade.php).
