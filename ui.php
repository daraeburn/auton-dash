<?php

function UIdrawBoxes($collections) {
    $width = intdiv(12,count($collections));
    
    $html= '<div class="container">
    <!--Row with four equal columns-->
    <div class="row">';
    foreach($collections as $collection){
        $html.='    <div class="col-md-'.$width.'">
            <div class="panel panel-'.$collection->color.'">
                <div class="panel-heading">'.$collection->title.'</div>
                    <div class="panel-body"><a href="'.$collection->link.'">'.$collection->getCount().'</a></div>
                </div>
            </div>';
    }
    $html.='</div>
        </div>';
    echo $html;
}

function UIdrawTitle() {
    echo '<h1 class="text-center">Auton Dashboard</h1>';
}

function UIhead() {
    echo '<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="'.pageRefreshSeconds.';URL='.page.'">
    <title>Auton Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional Bootstrap theme -->
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cerulean/bootstrap.min.css" rel="stylesheet" integrity="sha384-zF4BRsG/fLiTGfR9QL82DrilZxrwgY/+du4p/c7J72zZj+FLYq4zY00RylP9ZjiT" crossorigin="anonymous">
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    </head>
<body>
    <div class="container">';
}

function UIdrawFooter(){
    echo'';
    echo '<script>
        $(document).ready(function(){
            $(\'#defects\').dataTable();
            });
            </script>';
    echo '
    </div>
</body>
</html>';
}
?>