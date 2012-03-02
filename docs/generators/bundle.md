---
layout: default
title: Bundles
fork-path: https://github.com/daylerees
---

#Bundles

##Usage

Bob now generate bundle directories, with a `start.php`, simply use the command :

	bob bundle [args] <bundle_name>

<div class="alert alert-info">
<strong>Note :</strong> You can use the shortcut <strong>bob b</strong> instead of <strong>bob bundle</strong> to save characters.
</div>

##Arguments

None.

##Example

	bob bundle elephant

produces an `elephant` folder with a `start.php` containing :

{% highlight php startinline %}
<?php

/*
|--------------------------------------------------------------------------
| Auto-Loader Mappings
|--------------------------------------------------------------------------
|
| Laravel uses a simple array of class to path mappings to drive the class
| auto-loader. This simple approach helps avoid the performance problems
| of searching through directories by convention.
|
| Registering a mapping couldn't be easier. Just pass an array of class
| to path maps into the "map" function of Autoloader. Then, when you
| want to use that class, just use it. It's simple!
|
*/

Autoloader::map(array(

));

/*
|--------------------------------------------------------------------------
| Auto-Loader Directories
|--------------------------------------------------------------------------
|
| The Laravel auto-loader can search directories for files using the PSR-0
| naming convention. This convention basically organizes classes by using
| the class namespace to indicate the directory structure.
|
*/

Autoloader::directories(array(

));
{% endhighlight %}