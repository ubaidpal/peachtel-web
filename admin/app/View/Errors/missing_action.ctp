<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
$pluginDot = empty($plugin) ? null : $plugin . '.';
?>
<?php $this->layout = 'admindefault'; ?>
<div id="content">	
    <div id="contentHeader">
        <h1><?php echo ucfirst($this->params['controller']); ?></h1>
    </div> <!-- #contentHeader -->
    <div class="container">
        <div class="grid-24">
            <div style="margin: 0 0 0 0px !important;">
            <h2><?php echo __d('cake_dev', 'Error 404: Page Not Found.'); ?></h2>
            </div>
        </div>
    </div>
</div>
