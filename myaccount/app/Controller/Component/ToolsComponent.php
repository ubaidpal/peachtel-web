<?php

/** 
 * 
 * Created By Dev Gian - QuapAccent
 * Modified By Dev Gian - QuapAccent
 * Craeted 2/27/13
 * Modified 2/27/13

 */

App::uses('Component', 'Controller');
class ToolsComponent extends Component {
  
    function genPass($password) {
        /** define prestashop key*/
        $key = "qQC1Yc55ycYxXJ1wLcXuVLtJJvUDkE7R2af8v1FHW51vUWbEu03eZZGA";
        return md5($key. $password);

    }
  
}

?>