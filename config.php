<?php

return array(
  'host' =>'eu-cdbr-west-03.cleardb.net',
  'username' => 'b6e92ded5425a9',
  'password' =>'5636d5f8',
  'dbname' => 'heroku_d2693f3b5fa1c11'
);

function dbConnection($configs){
  $dbservername = $configs['host'];
  $dbusername = $configs['username'];
  $dbpassword = $configs['password'];
  $dbName = $configs['dbname'];
}
?>