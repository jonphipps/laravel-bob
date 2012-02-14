#Bob, can we generate it? YES WE CAN

##Installation

##Usage

###Controllers
Generate controllers with optional actions by using the `bob::build:controller` command.

Any extra 'words' supplied to the command will create actions and views.

```
php artisan bob::build:controller controllername firstaction secondaction ...
```

You can also use the --blade switch to generate views for each action in blade format.

```
php artisan bob::build:controller --blade controllername firstaction ...
```

###Models
Generate Eloquent models using the `bob::build:model` command.

```
php artisan bob::build:model user
```

You can use a colon (:) to add relationships to your eloquent models, for example..

```
php artisan bob::build:model user has_many:task
```

Always use the singular when defining relationships, if you have plurals in your config/strings.php it will be detected automatically.

You can use the --timestamps switch to add auto-timestamps to your model.

**Note** Save keystrokes by using the shorter relationship identifiers : hm, ho, bt, hbm. For example hm:user for has_many:user.

-----------------

Enjoy!
