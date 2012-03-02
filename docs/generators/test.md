---
layout: default
title: Tests
fork-path: https://github.com/daylerees
---

#Tests

##Usage
To generate a unit test for use with PHPUnit, use the following command :

	bob test [args] <test_name> [test_cases ...]

PHPUnit uses CamelCase for its class and functions, therefore tests can be created as in this example :

	bob test Something AThingWorks AnotherThingWorks

Bob will automatically prefix `Test` to the class and `test` to each test case.

<div class="alert alert-info">
<strong>Note :</strong> You can use the shortcut <strong>bob t</strong> instead of <strong>bob test</strong> to save characters.
</div>

##Arguments

None.


##Example

	bob test Something SomethingWorks AnotherThingWorks

produces :

{% highlight php startinline %}
<?php

class TestSomething extends PHPUnit_Framework_TestCase {

	/**
	 * Test that a given condition is met.
	 *
	 * @return void
	 */
	public function testSomethingWorks()
	{
		$this->assertTrue(true);	
	}

	/**
	 * Test that a given condition is met.
	 *
	 * @return void
	 */
	public function testAnotherThingWorks()
	{
		$this->assertTrue(true);	
	}

}

{% endhighlight %}