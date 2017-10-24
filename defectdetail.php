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
?>
