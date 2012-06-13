# miniMVC 

miniMVC is a minimalistic Modular MVC framework, with built-in minifier, and pure-PHP templating system.

### Requirements
* PHP 5.4+
* PDO extensions for databases you wish to use
* Webserver that correctly handles REQUEST_URI, such as:
	* Apache
	* IIS
	* Lighttpd
* SimpleTest library for running unit tests

### Unique features
#### Extensive use of PHP's magic methods on the base class
* `__toString()` method allows a view of the current class object when the current class object is used as a string. If you prefer `var_dump()` or `var_export()`, you can pass the name of that function if you call the `__toString` method directly.
		
	Eg. `$this . "string"`, `$this->__toString()`, `echo $this`;

* `__call()` method allows the dynamic addition of callable closure objects 

	Eg. `$this->foo = function($baz){}` is callable as `$this->foo()`, with  the current object as the last argument
	
* `MM` class extends ArrayObject, and all the main classes extend this class. Functions begining with `array_` are callable on object from this class. E.g. `$this->array_keys()` will return a list of the class properties.

#### Database class is an extension of PHP's PDO class.

Database class uses [Query](https://github.com/aviat4ion/Query) as a database abstraction layer and query builder. 

Database connections are set in /app/config/db.php

### File Structure

* index.php - framework bootstrap

* app 		- configuration and app-wide files
	* classes	- helper classes
	* config	- configuration files
	* modules 	- MVC triads
		* controllers 	- controller classes
		* models		- model classes
		* views			- module-specific views 
	* views 	- global page templates
		* errors	- error page templates

* assets 	- frontend files
	* js		- 	javascript files
	* css 		- 	css files
	* config  	-	minifier configuration files

* sys - core framework classes

### Common Tasks

* Creating a controller

		<?php 
		class Foo extends miniMVC\Controller {
			
			function __construct()
			{
				parent::__construct();
			}
		}
* Creating a model

		<?php
		class Bar extends miniMVC\Model {
		
			function __construct()
			{
				parent::__construct();
			}
		}

* Loading a database

	`$this->db = miniMVC\db::get_instance($db_name);`

	Note that multiple databases can be used in the same class
	by specifying a different database name. 

* Loading a model (From a controller)
	
	`$this->load_model($model)` - creates an instance of that model as a member of the current class. After loading the model, you can call its methods like so
	
	`$this->[model name]->method()`
	
* Loading a class
	
	Librarys / classes found in `app/classes` or `sys/libraries` are autoloaded.
	To call a library, simply instantiate that class.
	
	Classes with a `get_instance` static methods should be called like so:
	
	`$obj =& miniMVC\class::get_instance()`
	
	
	Other classes should be called using the new operator
	
	`$obj = new miniMVC\class()`
	
	