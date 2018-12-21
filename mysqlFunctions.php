<?php
function getConnection($hostname, $login, $password, $db = '')
{
    //TODO избавиться от параметра connection
    //TODO сделать проверку входящих параметров
    $connection = new mysqli($hostname, $login, $password, $db);
    if ($connection->connect_errno) {
        echo 'Не удалось подключиться к MySql: (' . $connection->connect_errno . ') ' . $connection->connect_error;
    }
    return $connection;
}

function createDb($connection, $dbName = '')
{
    //TODO избавиться от параметра connection
    //TODO сделать проверку входящих параметров
    /** @var mysqli $connection */
    if (! $connection->query("DROP DATABASE IF EXISTS {$dbName}") ||
        ! $connection->query("CREATE DATABASE {$dbName}")) {
        echo "Не удалось создать БД {$dbName}: (" . $connection->errno . ') ' . $connection->connect_error;
    }
}

function createTable($connection, $tableName, $params)
{
    //TODO избавиться от параметра connection
    //TODO сделать проверку входящих параметров
    $sql = implode(', ', array_map(
        function($v, $k) {
            if (! is_int($k)) {
                return $k . ' ' . $v;
            }
            return $v;
        },
        $params,
        array_keys($params)
    ));
    /** @var mysqli $connection */
    if (! $connection->query("CREATE TABLE {$tableName} ($sql)")) {
        echo "Не удалось создать таблицу {$tableName}: (" . $connection->errno . ') ' . $connection->connect_error;
    }
}
