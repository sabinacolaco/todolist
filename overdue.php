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
        <link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/build/css/bootstrap-datetimepicker.css"/>
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
                      <li class="active"><a href="#">Overdue</a></li>
                      <li><a href="<?=SITE_URL;?>completed-tasks">Completed</a></li>
                    </ul>
                </div>
            </nav>
            <h2>Overdue Tasks</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Task</th>
                        <th>Due Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rows = $process->todolistOverdue();
                    if (!empty($rows)) {
                        $i=1;
                        foreach ($rows as $k=>$v) {        
                            ?>
                            <tr>
                                <td><?=$i;?></td>
                                <td><?=$v['task'];?></td>
                                <td><?=$process->showDate($v['due_date']);?></td>
                                <td>
                                    <button type="button" data-toggle="modal" data-target="#rescheduleModal" class="btn btn-sm btn-info" data-id="<?=$v['id'];?>">Reschedule</button>&nbsp;&nbsp;
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    else {
                        ?>
                        <tr>
                            <td colspan="4" style="text-align: center;"><?=NO_RECORDS;?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Modal to reschedule a new task-->
        <div class="modal fade" id="rescheduleModal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit a task</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form id ="rform">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Task</label>
                                <input type="text" id="inputTask" name="inputTask" placeholder="Task" class="form-control" readonly/>
                            </div>
                            <div class="form-group">
                                <div class="input-group date datetimepicker">
                                <input type="text" class="form-control" id="inputDuedate" name="inputDuedate" placeholder="Due Date" onkeydown="return false"/>	<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
                                </div>
                            </div>
                            <input type="hidden" name="hdnformRID" id="hdnformRID" value="yes"/>
                            <input type="hidden" name="hdnedittaskId" id="hdnedittaskId" />      
                        </div>        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success edittask" id="submit" value="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/src/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript">
    var SITE_URL = "<?=SITE_URL;?>";
    </script>
    <script type="text/javascript" src="<?=SITE_URL;?>includes/todoscript.js"></script>
    </body>
</html>