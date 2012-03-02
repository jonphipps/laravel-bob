---
layout: default
title: Installation
fork-path: https://github.com/daylerees
---

#Installation

To install Bob, from the base of your laravel project simply type :


	php artisan bundle:install bob


And to activate the bundle, simply add `'bob'` to the array in your `application/bundles.php` :

	return array('bob', ... possible other stuff ..);

You can send commands to bob, using Laravel's Artisan tool with the following syntax :

	php artisan bob::build <generator> [args] [options]


However, I would recommend adding the following alias to your shell profile (.bashrc .zshrc .bash_profile .profile) :


	alias bob="php artisan bob::build"

and now you can invoke Bob in a more elegant format :


	bob <generator> [args] [options]

**All examples within the documentation will use the shortened aliased version for clarity.**
