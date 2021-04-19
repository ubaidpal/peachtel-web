<?php

class User extends AppModel{
    
    var $name = 'User';
    var $actsAs = array('Containable');
    var $useTable = "www_users";
}