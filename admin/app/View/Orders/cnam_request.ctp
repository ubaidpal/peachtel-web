<?php if(!$download) : ?>
<div class="widget widget-table">
    <div class="widget-header">
        <h3 style="margin-top: 10px;color:#454545;font-size: 16px"><?php echo count($numberList); ?> Results Found.</h3>	
        <?php if(!empty($numberList)) : ?>
            <a style="float: right; margin-right: 10px;" target="_blank" href="cnam_request/?download=true&phonenumber=<?php echo urlencode(implode(',', $numbers)); ?>">Download Csv file.</a>
        <?php endif; ?>
    </div>
    <div class="widget-content">
        <table class="table table-bordered table-striped data-table">
            <thead>
            <th>Name</th>
            <th>Price</th>
            <th>Uri</th>
            <th>Updated	</th>
            <th>Number</th>
            <th>Created</th>
            </thead>
            <?php
            foreach($numberList as $number) {
            if (!empty($number)) { ?>
                <tr class="gradeA">
                    <td> <?php echo $number->name ?> </td>
                    <td> $ <?php echo $number->price ?> </td>
                    <td> <?php echo $number->uri ?> </td>
                    <td> <?php echo $number->updated ?> </td>
                    <td><?php echo $number->number ?></td>
                    <td> <?php echo $number->created ?></td>
                </tr>
            <?php 
            } else { ?>
                <tr class="gradeA">
                    <td>No Result Found:</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php }}  ?>
        </table>
    </div> <!-- .widget-content -->
</div> <!-- .widget -->
<?php
else:
    $label = array('Number', 'Name', 'Search Cost', 'Uri', 'Updated', 'Created');
    $this->csv->addRow($label);
    foreach($numberList as $number) {
        $data = (array) $number;
        $row = array($data['number'], $data['name'], $data['price'], $data['uri'], $data['updated'], $data['created']);
        $this->csv->addRow($row);
    }
    echo $this->csv->render("cnam"); 
endif;
?>
