<?php

return array(
  'host' =>getenv('host'),
  'username' => getenv('username'),
  'password' => getenv('password'),
  'dbname' => getenv('dbname')
);

function dbConnection($configs){
  $dbservername = $configs['host'];
  $dbusername = $configs['username'];
  $dbpassword = $configs['password'];
  $dbName = $configs['dbname'];
}
?>
