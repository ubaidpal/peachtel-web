<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
echo $this->Html->tag('h3', 'Add Funds', array('class' => 'subheadings'));
?>
<ul type="none">
    <li>Account Balance $23423</li>
    <li>Auto Replenish is set to: <font style="color:red;"> ON</font> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <font style="color:blue; font-size: 12px;">Manage Auto Replinish</font></li>
    <li>Payment Method is Visa Card ending 7484 expring on 11/2017. Nick Name: Business Visa &nbsp;&nbsp;<font style="color:blue; font-size: 12px;">Update</font></li>
    <li>Make Payment of 
        <select>
            <option>$50</option>
        </select>
        <select>
            <option>Make payment</option>
        </select>
    </li>
</ul>
<?php echo $this->Html->tag('h3', 'Service Address', array('class' => 'subheadings')); ?>

<ul type="none">
    <li><b>My Company Name &nbsp;&nbsp;&nbsp;</b><font style="color:blue; font-size: 12px;">Edit/Change Password</font></li>
    <li>my name</li>
    <li>my street number</li>
    <li>second address line</li>
    <li>city, st zipcode</li>
    <li>country</li>
    <li>email </li>
    <li>phone number</li>
</ul>
<?php echo $this->Html->tag('h3', 'Billing History', array('class' => 'subheadings')); ?>
    <div class="container">
        <div ><table>
                <tr>
                    <td width="200px">Select Date Range </td>
                    <td width="210px"> From 
                        <select><option value="jan">jan</option></select>
                        <select><option value="1">1</option></select>
                        <select><option value="2012">2012</option></select>
                    </td>
                    <td width="210px"> Through 
                        <select><option value="jan">jan</option></select>
                        <select><option value="1">1</option></select>
                        <select><option value="2012">2012</option></select>
                    </td>
                    <td width="150px"> <input type="checkbox"/>All Dates</td>
                </tr>
            </table></div>

        <div>
            </br>
            <table id="table2">
                <tr>
                    <td width="130">show History For:</td>
                    <td width="70"><input type="checkbox"/>PBX</td>
                    <td ><input type="checkbox"/>Trunking</td>
                    <td width="130"><input type="checkbox"/>Store Purchase</td>
                    <td width="150px"><input type="checkbox"/>All</td>
                    <td width="153px"><button >show history>></button> </td>
                    <td><button >Get Invoice>></button> </td>
                </tr>
            </table>
        </div>
        </br>  
        <div>
            <table id="table3">
                <tr>
                    <th width="80px">Date</th>
                    <th  width="130">Type</th>
                    <th  width="485" style="text-align:left ">Description</th>
                    <th  width="130"> Amount</th>
                </tr>
            </table>
        </div>
    </div>