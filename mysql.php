<?php
require_once __DIR__ . 'mysqlFunctions.php';

//TODO избавиться от явного соединения
//TODO избавиться от параметра connection
//TODO проверить внешние ключи
$connection = getConnection('127.0.0.1', 'root', '123');
createDb($connection, 'forum');
$connection = getConnection('127.0.0.1', 'root', '123', 'forum');

$categoryColumns = [
    'id'   => 'INTEGER NOT NULL PRIMARY KEY',
    'name' => 'CHAR(255) NOT NULL',
];
createTable($connection, 'category', $categoryColumns);

$permissionColumns = [
    'id'          => 'INTEGER NOT NULL PRIMARY KEY',
    'description' => 'CHAR(255) NOT NULL',
    'name'        => 'CHAR(255) NOT NULL',
];
createTable($connection, 'permission', $permissionColumns);

$roleColumns = [
    'id'           => 'INTEGER NOT NULL PRIMARY KEY',
    'name'         => 'char(255) NOT NULL',
    'permissionId' => 'INTEGER NOT NULL',
];
createTable($connection, 'role', $roleColumns);

$roleVsPermissionColumns = [
    'permissionId' => 'INTEGER NOT NULL',
    'roleId'       => 'INTEGER NOT NULL',
    'FOREIGN KEY (permissionId) REFERENCES permission(id)',
    'FOREIGN KEY (roleId) REFERENCES role(id)',
];
createTable($connection, 'roleVsPermissions', $roleVsPermissionColumns);

$userColumns = [
    'id'       => 'INTEGER NOT NULL PRIMARY KEY',
    'name'     => 'CHAR(255) NOT NULL',
    'login'    => 'CHAR(255) NOT NULL',
    'roleId'   => 'INTEGER NOT NULL',
    'password' => 'char(255) NOT NULL',
];
createTable($connection, 'user', $userColumns);

$userVsRoleColumn = [
    'roleId' => 'INTEGER NOT NULL',
    'userId' => 'INTEGER NOT NULL',
    'FOREIGN KEY (roleId) REFERENCES role (id)',
    'FOREIGN KEY (userId) REFERENCES user (id)',
];
createTable($connection, 'userVsRole', $userVsRoleColumn);

$themeColumns = [
    'id'         => 'INTEGER NOT NULL PRIMARY KEY',
    'name'       => 'CHAR(255) NOT NULL',
    'categoryId' => 'INTEGER NOT NULL',
    'authorId'   => 'INTEGER NOT NULL',
    'FOREIGN KEY (categoryId) REFERENCES category(id)',
    'FOREIGN KEY (authorId) REFERENCES user(id)',
];
createTable($connection, 'theme', $themeColumns);

$messageColumns = [
    'id'       => 'INTEGER NOT NULL PRIMARY KEY',
    'themeId'  => 'INTEGER NOT NULL',
    'authorId' => 'INTEGER NOT NULL',
    'content'  => 'TEXT NOT NULL',
    'date'     => 'DATE NOT NULL',
    'FOREIGN KEY (themeId) REFERENCES theme(id)',
    'FOREIGN KEY (authorId) REFERENCES user(id)',
];
createTable($connection, 'message', $messageColumns);
