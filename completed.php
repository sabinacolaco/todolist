<?php
include('processtodo.php');
$process = new ProcessToDo();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?=SITE_NAME;?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?=SITE_URL;?>includes/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h3><?=SITE_NAME;?></h3>
            </div>
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand">TO DO Tasks</a>
                    </div>
                    <ul class="nav navbar-nav">
                      <li><a href="<?=SITE_URL;?>">Today</a></li>
                      <li><a href="<?=SITE_URL;?>upcoming-tasks">Upcoming</a></li>
                      <li><a href="<?=SITE_URL;?>overdue-tasks">Overdue</a></li>
                      <li class="active"><a href="#">Completed</a></li>
                    </ul>
                </div>
            </nav>
            <h2>Completed Tasks</h2>
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Task</th>
                        <th>Added Date</th>
                        <th>Due Date</th>
                        <th>Completed Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rows = $process->todolistCompleted();
                    if (!empty($rows)) {
                        $i=1;
                        foreach ($rows as $k=>$v) {        
                            ?>
                            <tr>
                                <td><?=$i;?></td>
                                <td><?=$v['task'];?></td>
                                <td><?=date('d/m/Y H:i A', strtotime($v['created_date']));?></td>
                                <td><?=date('d/m/Y H:i A', strtotime($v['due_date']));?></td>
                                <td><?=date('d/m/Y H:i A', strtotime($v['completed_date']));?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    else {
                        ?>
                        <tr>
                            <td colspan="5" style="text-align: center;"><?=NO_RECORDS;?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    });
    </script>
    </body>
</html>