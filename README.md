# php-safe-builder
PHP safe string builder. Builds SQL query.

![builder](https://github.com/zeroSal/php-safe-builder/assets/38191926/a0c5f1cb-f4f2-415e-8346-aeb660b573aa)

[Icon by Freepik - Flaticon](https://www.flaticon.com/free-icons/builder)

## Why this library?

PHP does not provide the capability to securely build SQL strings statically. One would need to rely on PDO or MySQLi, but what if there isn't a database to connect to and you just need to construct an escaped query?

An example use case: constructing an SQL string to be executed via STDIN in a mysql client on a remote server via SSH.

## Usage
```php
# Instantiate the object
$sqlBuilder = new SqlBuilder();

# Write the query template
$query = 'SELECT * FROM this_table WHERE this_field = :value AND other_field = :value2';

# Safely build the query
$safeQuery = $sqlBuilder->build($query, [
':value' => 'This is a value',
':value2' => 123
]);
```
