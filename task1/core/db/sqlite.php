<?php
function getDbConnection()
{
    $db = new PDO('sqlite:' . __DIR__ . '/database/bugtracker.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}
