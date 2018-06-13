# ClassFriendship

`ArashDalir/ClassFriendship` provides basic functionality needed to simulate class friendship like in c++. 
## Install

Use following command to add the repository to your project:

	composer require arashdalir/php-classfriendship


Or add following line to your composer.json:

```json
{
  "require": {
     "arashdalir/php-classfriendship": "dev-master"
  }
}
```

## Usage
The classes need to use `trait Friends` in their implementation. A new Friendship can be defined like this:
```php
<?php
namespace Test;

include "vendor/autoload.php";

use ArashDalir\ClassFriendship\Friends;
use ArashDalir\ClassFriendship\FriendshipTypes;

class A{
	use Friends;

	protected $parameter;

	function __construct() {
		static::addFriendship(B::class, FriendshipTypes::CAN_READ|FriendshipTypes::CAN_WRITE);
	}
}

class B{
	function testFriendship(){
		$a = new A();

		$a->parameter = "B can access this!";

		print_r($a);
	}
}

class C{
	function testFriendship()
	{
		$a = new A();

		$a->parameter = "C cannot access this! this will throw NotFriendsException";

		print_r($a);
	}
}

$b = new B();
$c = new C();

$b->testFriendship();
$c->testFriendship();

/*
prints:
Test\A Object ( [parameter:protected] => B can access this! )

throws:
 PHP Fatal error:  Uncaught exception 'ArashDalir\ClassFriendship\Exceptions\NotFriendsException' with message 'Class "Test\C" is not a friend of class "Test\A".' in D:\gamp\htdocs\tools\github\ClassFriendship\src\Friends.php:90
 Stack trace:
 #0 D:\gamp\htdocs\tools\github\ClassFriendship\src\Friends.php(62): Test\A->set('parameter', 'C cannot access...')
 #1 D:\gamp\htdocs\tools\github\ClassFriendship\demo.php(34): Test\A->__set('parameter', 'C cannot access...')
 #2 D:\gamp\htdocs\tools\github\ClassFriendship\demo.php(44): Test\C->testFriendship()
 #3 {main}
   thrown in D:\gamp\htdocs\tools\github\ClassFriendship\src\Friends.php on line 90
*/

```
