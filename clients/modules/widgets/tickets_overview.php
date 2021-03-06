<?php

function widget_supporttickets_overview($vars) {
    global $_ADMINLANG;

    $title = "Support Tickets Overview";

    $activestatuses = $replystatuses = array();
    $result = select_query("tblticketstatuses","title,showactive,showawaiting","showactive=1");
    while ($data = mysql_fetch_array($result)) {
        if ($data['showactive']) $activestatuses[] = $data['title'];
        if ($data['showawaiting']) $replystatuses[] = $data['title'];
    }

    $chartdata = array();
    $query = "SELECT name,(SELECT COUNT(*) FROM tbltickets WHERE tbltickets.did=tblticketdepartments.id AND tbltickets.status IN ('".implode("','",$replystatuses)."')) FROM tblticketdepartments ORDER BY `order` ASC";
    $result = mysql_query($query);
    while ($data = mysql_fetch_array($result)) {
        $chartdata[] = "['".$data[0]."',".$data[1]."]";
    }
    $chartdata = implode(',',$chartdata);

    $chartdata2 = array();
    $query = "SELECT tblticketstatuses.title,(SELECT COUNT(*) FROM tbltickets WHERE tbltickets.status=tblticketstatuses.title) FROM tblticketstatuses WHERE showawaiting=1 ORDER BY sortorder ASC";
    $result = mysql_query($query);
    while ($data = mysql_fetch_array($result)) {
        $chartdata2[] = "['".$data[0]."',".$data[1]."]";
    }
    $chartdata2 = implode(',',$chartdata2);

    $content = <<<EOF
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawTicketChart1);
      function drawTicketChart1() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Department');
        data.addColumn('number', 'Ticket Count');
        data.addRows([
          $chartdata
        ]);

        var options = {
          chartArea: {left:0,top:20,width:"100%",height:"160"},
          title: 'Awaiting Reply by Department'
        };

        var chart = new google.visualization.PieChart(document.getElementById('ticketsoverview1'));
        chart.draw(data, options);
      }
      google.setOnLoadCallback(drawTicketChart2);
      function drawTicketChart2() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Status');
        data.addColumn('number', 'Ticket Count');
        data.addRows([
          $chartdata2
        ]);

        var options = {
          chartArea: {left:0,top:20,width:"100%",height:"160"},
          title: 'Awaiting Reply by Status'
        };

        var chart = new google.visualization.PieChart(document.getElementById('ticketsoverview2'));
        chart.draw(data, options);
      }

    </script>

    <div id="ticketsoverview1" style="float:left;width: 50%; height: 200px;"></div>
    <div id="ticketsoverview2" style="float:right;width: 50%; height: 200px;"></div>

EOF;

    return array('title'=>$title,'content'=>$content);

}

add_hook("AdminHomeWidgets",1,"widget_supporttickets_overview");

?>