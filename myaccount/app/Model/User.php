<?php

class User extends AppModel {
    
    var $name = 'User';
    var $actsAs = array('Containable');
    var $useDbConfig = 'whmcs';
    var $useTable = "tblclients";
    
    var $virtualFields = array(
        'username' => 'User.email'
    );
}

?>