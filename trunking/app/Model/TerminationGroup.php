<?php

class TerminationGroup extends AppModel{
    
    var $name = 'TerminationGroup';
    var $actsAs = array('Containable');
    var $useTable = "vendor_term_group";
    
    
}