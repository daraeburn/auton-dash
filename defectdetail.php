<?php

require 'defects.php';
require 'ui.php';

use StepanSib\AlmClient\AlmClient;
use StepanSib\AlmClient\AlmEntityManager;

if (isset($_GET['defectid'])) {
    $defectid = $_GET['defectid'];
}else{
    $defectid = 0;
}

$defect = DefectCollection::GetDefectByID($defectid);

UIDefectHead();
UIdrawDefectTitle($defect);

echo '<form>
<div class="form-group">
<label for="summary">Summary</label>
<input class="form-control" type="text" id="summary" value="'.$defect->name.'">
</div>

<div class="panel">
    <div class="form-group panel panel-default col-md-3">
    <label for="dCreatedDate">Detected on</label>
    <input class="form-control" type="text" id="dCreatedDate" value="'.$defect->{'creation-time'}.'">
    <!--input type="submit" class="button" name="update" value="update" /-->
    </div>

    <div class="form-group panel panel-default col-md-3">
    <label for="severity">Severity</label>
    <input class="form-control" type="text" id="severity" value="'.$defect->severity.'">
    </div>

    <div class="form-group panel panel-default col-md-3">
    <label for="state">State</label>
    <input class="form-control" type="state" id="severity" value="'.$defect->{'user-23'}.'">
    </div>

    <div class="form-group panel panel-default col-md-3">
    <label for="assignedTo">Assigned To</label>
    <input class="form-control" type="assignedTo" id="assignedTo" value="'.$defect->{'user-02'}.'">
    </div>
</div>
    

<div class="form-group">
<label for="type">Type</label>
<input class="form-control" type="type" id="assignedTo" value="'.$defect->{'user-42'}.'">
</div>

<div class="form-group">
<label for="detectedBy">Detected By</label>
<input class="form-control" type="type" id="detectedBy" value="'.$defect->{'detected-by'}.'">
</div>

<div class="form-group">
<label for="tags">Tags</label>
<input class="form-control" type="type" id="tags" value="'.$defect->{'user-89'}.'">
</div>

<div class="form-group">
<label for="description">Description</label>
'.$defect->description.'
</div>

<input type="button" class="btn btn-primary" value="Back" onClick="goBack()"/>
</form>
';

UIdrawDetailFooter($defectid);
DefectCollection::Logout();

function UIDefectHead() {
    echo '<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Auton Defect detail</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/2.18.1/moment.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/canvasjs.min.js"></script>
    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/wysihtml5/0.3.0/wysihtml5.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/locales/bootstrap-wysihtml5.en-US.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.css"></style>
    

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.css"></style>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="custom.css">
    <!-- Optional Bootstrap theme -->
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cerulean/bootstrap.min.css" rel="stylesheet" integrity="sha384-zF4BRsG/fLiTGfR9QL82DrilZxrwgY/+du4p/c7J72zZj+FLYq4zY00RylP9ZjiT" crossorigin="anonymous">
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"/>

    </head>
<body>
    <div class="container">';
}

function UIdrawDefectTitle($defect) {
    echo '<table style="width: 100%;">
        <tr><td><h1>Defect detail - '.$defect->id.'</h1></td>
        <td class="pull-right"><h1>Auton Details</h1></td></tr>
        </table>';
}

function UIdrawDetailFooter($defectid){
    echo'';
    echo '<script>

    function goBack() {
        window.history.back();
    }

    $(document).ready(function(){

        $("#description").wysihtml5();

        $(".button").click(function(){
            var clickBtnValue = $(this).val();
            var ajaxurl = "ajax.php",
            data =  {"action": clickBtnValue,
                "defectid": '.$defectid.',
                "createdDate": document.getElementById("dCreatedDate").value,
                "name": document.getElementById("summary").value};
            $.post(ajaxurl, data, function (response) {
                // Response div goes here.
                alert("action performed successfully");
            });
        });
    });
    </script>
</div>
</body>
</html>';
}

?>
