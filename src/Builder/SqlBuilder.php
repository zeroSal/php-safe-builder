<?php

namespace App\Service;

/**
 * @author Luca Saladino <sal65535@protonmail.com>
 */
class SqlBuilder
{
    /**
     * PDO like SQL safe builder.
     *
     * @param string $query The SQL query having at least a :placeholder.
     * @param array $parameters An associative :placeholder => 'value' array.
     *
     * @return string The built query.
     *
     * ```php
     * $sqlBuilder = new SqlBuilder();
     * $query = 'SELECT * FROM this_table WHERE this_field = :value AND other_field = :value2';
     * $safeQuery = $sqlBuilder->build($query, [
     *     ':value' => 'This is a value',
     *     ':value2' => 123
     * ]);
     * ```
     *
     */
    public function build(string $query, array $parameters): string
    {
        $builtQuery = $query;

        $escapedParameters = [];
        foreach ($parameters as $name => $value) {
            if (is_int($value)) {
                $builtQuery = str_replace($name, strval($value), $builtQuery);
                continue;
            }

            if (is_bool($value)) {
                $builtQuery = str_replace($name, $value ? 1 : 0, $builtQuery);
                continue;
            }

            $escapedParameters[] = [$name => $this->escapeParameter($value)];
            $builtQuery = str_replace($name, '"'.$value.'"', $builtQuery);
        }

        return $builtQuery;
    }

    public function escapeParameter($parameter)
    {
        if (is_int($parameter) or is_bool($parameter)) {
            return $parameter;
        }

        $search = ['\\',  "\x00", "\n",  "\r",  "'",  '"', "\x1a"];
        $replace = ['\\\\', '\\0', '\\n',  '\\r', "\\'", '\\"', '\\Z'];

        return str_replace($search, $replace, $parameter);
    }
}
