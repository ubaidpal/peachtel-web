<div class="header"><h3>Filter:</h3></div>
<div class="filter_form">
    <?php echo $this->form->input('customer', array('type' => 'select', 'options' => $customersList)); ?>
    <?php echo $this->form->input('source_contains'); ?>
    <?php echo $this->form->input('destination_contains'); ?>
    <?php echo $this->Html->link('Search Filter', 'javascript:void(0);', array('id' => 'searchFilterBtn')); ?>
</div>
<div class="content_holder">
    <table>
        <tr>
            <th>Source</th>
            <th>Destination</th>
            <th>Customer</th>
            <th>Duration</th>
            <th>Post Answer Duration</th>
            <th>Action</th>
        </tr>
        <?php foreach($cdrs as $cdr) : ?>
        <tr>
            <td><?php echo $cdr['Cdr']['src']; ?></td>
            <td><?php echo $cdr['Cdr']['dest']; ?></td>
            <td><?php echo $cdr['Customer']['descr']; ?></td>
            <td><?php echo $cdr['Cdr']['duration_sec']." sec"; ?></td>
            <td style="border-left: 1px solid #ccc; width: 200px"><?php echo $cdr['Cdr']['post_answer_duration_sec']." sec"; ?></td>
            <td>
                <?php echo $this->Html->link('View Details', '/cdrs/view/'.$cdr['Cdr']['id']); ?>
                <?php echo $this->Html->link('View Rating', '/cdrs/view_rating/'.$cdr['Cdr']['id']); ?>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
    <div>
        <?php 
            echo $this->Paginator->prev(' ' . __('Prev '), array(), null, array('class' => 'prev disabled'));
            echo ' | ';
            echo $this->Paginator->numbers(array('separator' => ' | '));
            echo ' | ';
            echo $this->Paginator->next(__(' Next') . ' ', array(), null, array('class' => 'next disabled'));
        ?>
    </div>
</div>

<script>
    $(function(e) {
        var cust;
        var src;
        var dest;
        
        $('span a').live('click', function() {
            
            var url = $(this).attr('href');
            var page = url.split(':');
            
            $.ajax({
                type : "POST",
                url : "<?php echo $this->base; ?>/cdrs/cdr_filter/page:"+page[1],
                data : {customer : cust, source : src, destination : dest},
                success : function(data){
                    $('.content_holder').html(data);
                }
            });
            
            return false;
        });
        
        $("#searchFilterBtn").live('click', function() {

            cust = $("#customer").val();
            src  = $("#source_contains").val();
            dest = $("#destination_contains").val();
            
            $.ajax({
                type : "POST",
                url : "<?php echo $this->base; ?>/cdrs/cdr_filter",
                data : {customer : cust, source : src, destination : dest},
                success : function(data){
                    alert(data);
                    $('.content_holder').html(data);
                }
            });
        });
        
    })
</script>
