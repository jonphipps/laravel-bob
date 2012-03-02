---
layout: default
title: GitHub Projects
fork-path: https://github.com/sparksp
---

#Bob

![Bob Logo](http://daylerees.com/boblogo.png)

Bob can be used to generate all kinds of useful files and classes, for use with the wonderfully fabulous Laravel PHP Framework, authored by Taylor Otwell.

If you have used ruby on rails' generate, or FuelPHP's Oil you will be familiar with its syntax.

Bob was created by Dayle Rees, with thanks to Phill Sparks, Eric Barnes and Taylor Otwell for all the help and support.

**Latest Changes:**

* Nested resources can now be generated.
* PHPUnit tests can now be generated.
* Bundles can now be generated.
* Output is now colored for clarity.
* Many bug fixes and refactors.

---

##Installation

To install Bob, from the base of your laravel project simply type :

```
php artisan bundle:install bob
```

And to activate the bundle, simply add `'bob'` to the array in your `application/bundles.php` :

```
return array('bob', ... other stuff ..);
```

---

##Usage

You can send commands to bob, using Laravel's Artisan tool with the following syntax :

```
php artisan bob::build <generator> [args] [options]
```

However, I would recommend adding the following alias to your shell startup file (.bashrc .zshrc) :

```
alias bob="php artisan bob::build"
```

and now you can invoke Bob in a more elegant format :

```
bob <generator> [args] [options]
```

---

##Global Arguments

Using `--force` will force Bob to overwrite files and folders, if they already exist.

Using `--pretend` will show the result of a Bob generation, without writing the changes to the filesystem.

---

## Generation Reference

Most of the commands, can generate code for a bundle, to specify that you wish to do so, simply add the bundle name and a double colon before the class name, for example :

```
bob controller mybundle::controllername
```

Many resources can be generated for subfolders, to do this simply use periods (.) to seperate folders and resources, for example :

```
bob controller mybundle::afolder.anotherfolder.controllername
```

Class prefixes will be added automatically.

###Controllers

To generate controllers with actions, and view files, simply pass the action names as extra arguments to the `controller` command :

```
bob controller [args] <controller_name> [actions ...]
```

**Note :** *You can use the shortcut `bob c` instead of `bob controller` to save characters.*

Use the `--blade` switch anywhere within the command to generate view files with the Blade extension (.blade.php).

###Models

To generate Eloquent models, simply use the `model` command :

```
bob model [args] <model_name> [relationships ...]
```
**Note :** *You can use the shortcut `bob m` instead of `bob model` to save characters.*

Relationships can be defined in the format `relationship_type:object_name` for example :

```
bob model users has_many:task
```
**Note:** *Always use the singular when generating relationships, if plurals are defined in the laravel `strings.php` file, they will be converted automatically.*

Here is a list of acceptable relationships, and their shortcuts :

* `has_many` or `hm`
* `has_one` or `ho`
* `belongs_to` or `bt`
* `has_and_belongs_to_many` or `hbm`

You can also add automatic timestamps to your models by adding the argument `--timestamps` or `--t`. Remember to create the updated_at and created_at fields to your database.

###Migrations

Artisan is already able to generate migrations, however I have provided a handy 'wrapper' method to bob to enable quick creation.

To make a new migration simply use the format :

```
bob migration <migration_name>
```
**Note :** *You can use the shortcut `bob mig` instead of `bob migration` to save characters.*

For more information and switches, see the Laravel documentation.

###Tests

To generate a unit test for use with PHPUnit, use the following command :

```
bob test [args] <test_name> [test_cases ...]
```

PHPUnit uses CamelCase for its class and functions, therefore tests can be created as in this example :

```
bob test Something AThingWorks AnotherThingWorks
```

Bob will automatically prefix `Test` to the class and `test` to each test case.

**Note :** *You can use the shortcut `bob t` instead of `bob test` to save characters.*

###Bundles

Bob can now generate bundle directories, with a `start.php`, simply use the command :

```
bob bundle [args] <bundle_name>
```

**Note :** *You can use the shortcut `bob b` instead of `bob bundle` to save characters.*

---

##Project Specific Templates

Bob templates can be customized on a per project basis, to add custom templates simply copy the files at

```
/bundles/bob/templates/*
```

to

```
/application/bob/*
```

You may then customize the templates within the bob folder, markers are displayed with #symbols#.

===================

More to come soon! Thanks for using Bob!
