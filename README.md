[![Latest Stable Version](https://poser.pugx.org/mouf/security.daos.tdbm/v/stable)](https://packagist.org/packages/mouf/security.daos.tdbm)
[![Total Downloads](https://poser.pugx.org/mouf/security.daos.tdbm/downloads)](https://packagist.org/packages/mouf/security.daos.tdbm)
[![Latest Unstable Version](https://poser.pugx.org/mouf/security.daos.tdbm/v/unstable)](https://packagist.org/packages/mouf/security.daos.tdbm)
[![License](https://poser.pugx.org/mouf/security.daos.tdbm/license)](https://packagist.org/packages/mouf/security.daos.tdbm)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/thecodingmachine/security.daos.tdbm/badges/quality-score.png?b=1.0)](https://scrutinizer-ci.com/g/thecodingmachine/security.daos.tdbm/?branch=1.0)


TDBM DAOs for Mouf security
===========================

What is it?
-----------

This package contains a set of TDBM DAOs adding a basic user / role / right support for Mouf security.

This package will create tables for users, roles and rights.

Installation
------------

Run:

```
composer require mouf/security.daos.tdbm
```

Then, go to the Mouf user interface.

In Mouf:

 - run the install tasks.
 - apply the database patches
 - regenerate TDBM DAOs

At this point, you should have a database with 4 additional tables: `users`, `users_roles`, `roles`, `roles_rights`.

Check the newly generated `UserBean` class.

Change this class so that:

- it extends `UserInterface`
- it uses the `UserTrait`

```php
use Mouf\Security\DAO\UserTrait;
use Mouf\Security\UserService\UserInterface;

/**
 * The UserBean class maps the 'users' table in database.
 */
class UserBean extends UserBaseBean implements UserInterface
{
    use UserTrait;
}
```
