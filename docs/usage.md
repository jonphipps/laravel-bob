---
layout: default
title: Usage
fork-path: https://github.com/daylerees
---

#Usage

You can send commands to bob, using Laravel's Artisan tool with the following syntax :

	php artisan bob::build <generator> [args] [options]


However, I would recommend adding the following alias to your shell startup file (.bashrc .zshrc) :


	alias bob="php artisan bob::build"

and now you can invoke Bob in a more elegant format :


	bob <generator> [args] [options]

All examples within the documentation will use the shortened aliased version for clarity.
