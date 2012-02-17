#Bob

Bob can be used to generate all kinds of useful files and classes, for use with the wonderfully fabulous Laravel PHP Framework, authored by Taylor Otwell.

Bob was created by Dayle Rees, and thanks to Phill Sparks, Eric Barnes and Taylor Otwell for all the help and support.

##Installation

To install Bob, from the base of your laravel project simply type :

```
php artisan bundle:install bob
```

And to activate the bundle, simply add `'bob'` to the array in your `application/bundles.php` :

```
return array('bob', ... other stuff ..);
```

##Usage

You can send commands to bob, using Laravel's Artisan tool with the following syntax :

```
php artisan bob::build <command> [argument] [argument] [--config]
```

However, I would recommend adding the following alias to your shell startup file (.bashrc .zshrc) :

```
alias bob="php artisan bob::build"
```

and now you can invoke Bob in a more elegant format :

```
bob <command> [argument] [argument] [--config]
```

## Generation Reference

Most of the commands, can generate code for a bundle, to specify that you wish to do so, simply add the bundle name, and a double colon before the class name, for example :

```
bob controller bundle::class
```

###Controllers

Controllers can be generated for the Laravel application itself, or even a registered Laravel bundle.

To generate actions, with view files, simply pass the action names as extra arguments to the `controller` command :

```
bob controller <controller_name> [<first_action> <second_action> ...]
```

**Note : You can use the shortcut `bob c` instead of `bob controller` to save characters.

Use the `--blade` switch anywhere within the command to generate view files with the Blade extension (.blade.php).
