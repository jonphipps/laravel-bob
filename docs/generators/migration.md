---
layout: default
title: Migrations
fork-path: https://github.com/daylerees
---

#Migrations

##Usage
Artisan is already able to generate migrations, however Bob includes a handy 'wrapper' method to bob to enable quick creation.

To make a new migration simply use the command :

	bob migration <migration_name>

<div class="alert alert-info">
<strong>Note :</strong> You can use the shortcut <strong>bob mig</strong> instead of <strong>bob migration</strong> to save characters.
</div>

##Arguments

For more information and switches, see the Laravel documentation.


##Example

	bob mig create_users

produces :

{% highlight php startinline %}
<?php

class Create_Users {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
{% endhighlight %}
