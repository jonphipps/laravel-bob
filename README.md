#Bob

Bob can be used to generate all kinds of useful files and classes, for use with the wonderfully fabulous Laravel PHP Framework, authored by Taylor Otwell.

Bob was created by Dayle Rees, with thanks to Phill Sparks, Eric Barnes and Taylor Otwell for all the help and support.

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

Most of the commands, can generate code for a bundle, to specify that you wish to do so, simply add the bundle name and a double colon before the class name, for example :

```
bob controller bundle::class
```

###Controllers

To generate controllers with actions, and view files, simply pass the action names as extra arguments to the `controller` command :

```
bob controller <controller_name> [first_action] [second_action] ...
```

**Note : You can use the shortcut `bob c` instead of `bob controller` to save characters.**

Use the `--blade` switch anywhere within the command to generate view files with the Blade extension (.blade.php).

###Models

To generate Eloquent models, simply use the `model` command :

```
bob model <model> [relationship] [relationship] ...
```
**Note : You can use the shortcut `bob m` instead of `bob model` to save characters.**

Relationships can be defined in the format :

```
relationship_type:object_name
```

for example :

```
bob model users has_many:task
```
**Note: Always use the singular when generating relationships, if plurals are defined in the laravel `strings.php` file, they will be converted automatically.**

Here is a list of acceptable relationships, and their shortcuts :

* has_many or hm
* has_one or ho
* belongs_to or bt
* has_and_belongs_to_many or hbm

You can also add automatic timestamps to your models by adding the switch `--timestamps` or `--ts`. Remember to create the updated_at and created_at fields to your database.

###Migrations

Artisan is already able to generate migrations, however I have provided a handy 'wrapper' method to bob to enable quick creation.

To make a new migration simply use the format :

```
bob migration <migration_name>
```
**Note : You can use the shortcut `bob mig` instead of `bob migration` to save characters.**

For more information and switches, see the Laravel documentation.


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
