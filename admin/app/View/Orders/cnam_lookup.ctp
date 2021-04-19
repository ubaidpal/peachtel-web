<Style>
    .input {
        margin-bottom: 5px;
    }
    .input label {
        vertical-align: top;
        width: 200px;
    }
    textarea {
        width: 70%;
    }
    #searchCNAM {
        float: right;
        margin: 0 310px 20px 0;
    }
</style>
<div id="content">	
    <div id="contentHeader">
        <h1>OpenCnam</h1>
    </div> <!-- #contentHeader -->
    <div class="container">
    <!--  <div>
        </div>-->
        <div class="grid-24">
            <div class="box" id="categories">
                <?php echo $this->Form->input('cnam', array('type' => 'textarea', 'label' => 'Phone Number: (10 Digit numbers, Comma delimited. eg: 6xxxxxxxxx, 4xxxxxxxxxx)')); ?>
                <br />
                <button id="searchCNAM" class="btn btn-teal">Search</button>
                <br /><br />
                <div id="result"></div>
            </div>
        </div>
    </div>
</div> <!-- #content -->
<script type="text/javascript">
$("#searchCNAM").live('click', function() {
    $("#result").html("<img src='<?php echo $this->base; ?>/images/loaders/big-roller.gif' />");
    var phoneNumber = $("#cnam").val();
    $.ajax({
        url: "cnam_request",
        type: "POST",
        data: {phonenumber: phoneNumber},
        async: false,
        success: function(result) {

            $("#result").html(result);
        }
    });
});
</script>