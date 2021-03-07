<?php
include('processtodo.php');
$process = new ProcessToDo();

if (!empty($_POST)) {

    if (isset($_POST['hdnAddform']) && ($_POST['hdnAddform'] == 'yes')) {
        echo $process->insertTask();
    }
    else if (isset($_POST['hdnEditform']) && ($_POST['hdnEditform'] == 'yes') && (!empty($_POST['hdnedittaskId']))) {
        echo $process->editTask();
    }
    else if (isset($_POST['hdnformRID']) && ($_POST['hdnformRID'] == 'yes') && (!empty($_POST['hdnedittaskId']))) {
        echo $process->rescheduleTask();
    }
    else if (isset($_POST['completed']) && ($_POST['completed'] == '1') && (!empty($_POST['taskId']))) {
        echo $process->markCompleted();
    }

} else if (!empty($_GET)) {

    if (isset($_GET['edittaskId']) && !empty($_GET['edittaskId'])) {
        echo $process->readTask();
    }
    else if(isset($_GET['deltaskId']) && !empty($_GET['deltaskId'])) {
        echo $process->deleteTask();
    }
}
?>