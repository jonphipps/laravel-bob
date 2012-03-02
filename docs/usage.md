---
layout: default
title: Usage
fork-path: https://github.com/daylerees
---

#Usage

##General

You can send commands to bob, using Laravel's Artisan tool with the following syntax :

	php artisan bob::build <generator> [args] [options]


However, I would recommend adding the following alias to your shell profile (.bashrc .zshrc .bash_profile .profile) :


	alias bob="php artisan bob::build"

and now you can invoke Bob in a more elegant format :


	bob <generator> [args] [options]

All examples within the documentation will use the shortened aliased version for clarity.

##Nested Folders

Almost all resources can be created within nested folders, when specifying the resource name, simply use periods (.) to mark a folder seperator.

For example `bob controller this.is.my.controller` will create `application/controllers/this/is/my/controller.php`.

##Generation In Bundles

Most resources can be generated for bundles, by prefixing `bundlename::` to the resource name.