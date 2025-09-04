<?php
require_once 'request.php';

try
{
    $body['order'] = 'id';
    $body['direction'] = 'asc';
    $location = 'http://localhost/projeto1/users';
    // senha: Basic + rest_key
    $users = request($location, 'GET', $body, 'Basic 123');
    
    print_r($users);
}
catch (Exception $e)
{
    print $e->getMessage();
}