---
layout: default
title: Views
fork-path: https://github.com/daylerees
---

#Views

##Usage
To generate a view file, simply use the following command :

	bob view [args] <view_name>

<div class="alert alert-info">
<strong>Note :</strong> You can use the shortcut <strong>bob v</strong> instead of <strong>bob view</strong> to save characters.
</div>

##Arguments


`--blade` Generate view files with the Blade extension (.blade.php).

##Example

	bob view wimble

produces :

{% highlight html startinline %}
<h1>wimble</h1>

<p>This is the 'wimble' view.</p>
{% endhighlight %}
