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
                      <li class="active"><a href="#">Upcoming</a></li>
                      <li><a href="<?=SITE_URL;?>overdue-tasks">Overdue</a></li>
                      <li><a href="<?=SITE_URL;?>completed-tasks">Completed</a></li>
                    </ul>
                </div>
            </nav>
            <h2>Upcoming Tasks</h2>
            <div class="row mb-20">
                <div class="col-lg-12">
                    <button type="button" data-toggle="modal" data-target="#addModal" class="btn btn-sm btn-success pull-right">Add</button>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Task</th>
                        <th>Day & Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rows = $process->todolistUpcoming();
                    if (!empty($rows)) {
                        $i=1;
                        foreach ($rows as $k=>$v) {        
                            ?>
                            <tr>
                                <td><?=$i;?></td>
                                <td><?=$v['task'];?></td>
                                <td><?=$process->showDate($v['due_date']);?></td>
                                <td>
                                    <button type="button" data-toggle="modal" data-target="#editModal" class="btn btn-sm btn-info" data-id="<?=$v['id'];?>">Edit</button>&nbsp;&nbsp;
                                    <button type="button" data-toggle="modal" data-target="#deleteModal" class="btn btn-sm btn-danger" data-id="<?=$v['id'];?>">Delete</button>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-sm <?=($v['is_completed']==1)?'btn-secondary':'btn-warning';?>" id="completebtn<?=$v['id'];?>" onclick='markComplete("<?=$v['id'];?>")'>Mark as Complete</button>
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
        
        <!-- Modal to add a new task-->
        <div class="modal fade" id="addModal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add a new task</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form id ="addform">
                        <div class="modal-body">
                            <div class="error-messages" id="error"></div>
                            <div class="form-group">
                                <label for="name" class="required">Task</label>
                                <input type="text" id="inputTaskAdd" name="inputTask" placeholder="Task" class="form-control" required/>
                            </div>
                            <div class="form-group">
                                <div class="input-group date datetimepicker">
                                <input type="text" class="form-control" id="inputDuedateAdd" name="inputDuedate" placeholder="Due Date" onkeydown="return false"/>	<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
                                </div>
                            </div>
                            <input type="hidden" name="hdnAddform" id="hdnAddform" value="yes"/>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success" id="submit" value="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal to edit a new task-->
        <div class="modal fade" id="editModal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit a Task</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form id ="editform" action="insertajax.php">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Task</label>
                                <input type="text" id="inputTask" name="inputTask" placeholder="Task" class="form-control" />
                            </div>
                            <div class="form-group">
                                <div class="input-group date datetimepicker">
                                <input type="text" class="form-control" id="inputDuedate" name="inputDuedate" placeholder="Due Date" onkeydown="return false"/>	<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
                                </div>
                            </div>
                            <input type="hidden" name="hdnEditform" id="hdnEditform" value="yes"/>
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

        <!-- Modal to delete a new task-->
        <div class="modal fade" id="deleteModal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert">
                            Are you sure you want to delete the record?
                        </div>
                        <input type="hidden" name="hdntaskId" id="hdntaskId" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger delete" id="confirm-button">Yes</button>
                    </div>
                </div>
            </div>
        </div>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/src/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript">
    var SITE_URL = "<?=SITE_URL;?>";
    </script>
    <script type="text/javascript" src="<?=SITE_URL;?>includes/todoscript.js"></script>
    </body>
</html>