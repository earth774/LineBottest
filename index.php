<?php
$host = 'ec2-54-235-160-57.compute-1.amazonaws.com';
$dbname = 'dbgi88drnrb4b2';
$user = 'gyyihuipnfrnst';
$pass = 'bb1d0f4530c5eb1c470b71bfcf9402465a41a8e793220072fb5e30a00daa18ff';
$connection = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
$result = $connection->query("SELECT * FROM polls");
if ($result !== null) {
    echo $result->rowCount();
}
