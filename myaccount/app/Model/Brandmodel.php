<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Brandmodel extends AppModel {
     public $validate=array(
        'username'=>array('rule'=>'notEmpty'),
        'password'=>array('rule'=>'notEmpty')
    );
}

?>
