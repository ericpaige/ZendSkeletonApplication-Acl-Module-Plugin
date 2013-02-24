About this directory:
=====================

By default, this application is configured to load all configs in
`./config/autoload/{,*.}{global,local}.php`. Doing this provides a
location for a developer to drop in configuration override files provided by
modules, as well as cleanly provide individual, application-wide config files
for things like database connections, etc.

Note: The Album module requires a databases connection. Add a file in this directory called "local.php" with this contents:

```php
<?php
return array(
    'db' => array(
        'username' => 'db_username',
        'password' => 'db_password',
    ),
);
```
