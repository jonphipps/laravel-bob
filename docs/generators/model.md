---
layout: default
title: Models
fork-path: https://github.com/daylerees
---

#Models

##Usage
To generate Eloquent models, simply use the `model` command :

	bob model [args] <model_name> [relationships ...]

<div class="alert alert-info">
<strong>Note :</strong> You can use the shortcut <strong>bob m</strong> instead of <strong>bob model</strong> to save characters.
</div>

Relationships can be defined in the format `relationship_type:object_name` for example :

	bob model users has_many:task

<div class="alert alert-info">
<strong>Note :</strong> Always use the singular when generating relationships, if plurals are defined in the laravel <strong>strings.php</strong> file, they will be converted automatically.
</div>

Here is a list of acceptable relationships, and their shortcuts :

* `has_many` or `hm`
* `has_one` or `ho`
* `belongs_to` or `bt`
* `has_and_belongs_to_many` or `hbm`


##Arguments


`--timestamps` Add automatic timestamping to your model. Remember to create the updated_at and created_at fields to your database.



##Example

	bob model user has_many:task belongs_to:profile --timestamps

produces :

{% highlight php startinline %}
<?php

class User extends Eloquent\Model {

	public static $timestamps = true;

	public function task()
	{
		return $this->has_many('Task');
	}

	public function profile()
	{
		return $this->belongs_to('Profile');
	}

}

{% endhighlight %}