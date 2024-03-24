<?php
include('config/Constants.php');
include('config/Database.php');

class ProcessToDo {
    
    private $db;

    public function __construct()
    {
        $this->db = new mysqli($GLOBALS['host'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['db_name']);
        
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    /**
    * todolistToday function.
    * List the current tasks - called from index.php
    * @return $result_array
    */
    public function todolistToday()
    {
        $result_array = [];
        $sql = "SELECT * FROM todolist WHERE date(due_date) = CURDATE() ORDER BY due_date";
        $result = $this->db->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $result_array[] = $row;
            }
        }
       
        return $result_array;
    }

    /**
    * todolistUpcoming function.
    * List the upcoming tasks - called from upcoming.php
    * @return $result_array
    */
    public function todolistUpcoming()
    {
        $result_array = [];
        $sql = "SELECT * FROM todolist WHERE date(due_date) > CURDATE() ORDER BY due_date";
        $result = $this->db->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $result_array[] = $row;
            }
        }
       
        return $result_array;
    }

    /**
    * todolistOverdue function.
    * List the upcoming tasks - called from overdue.php
    * @return $result_array
    */
    public function todolistOverdue()
    {
        $result_array = [];
        $sql = "SELECT * FROM todolist WHERE date(due_date) < CURDATE() AND is_completed = 0 ORDER BY due_date";
        $result = $this->db->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $result_array[] = $row;
            }
        }
       
        return $result_array;
    }

    /**
    * todolistCompleted function.
    * List the upcoming tasks - called from completed.php
    * @return $result_array
    */
    public function todolistCompleted()
    {
        $result_array = [];
        $sql = "SELECT * FROM todolist WHERE is_completed = 1 ORDER BY due_date";
        $result = $this->db->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $result_array[] = $row;
            }
        }
       
        return $result_array;
    }

    /**
    * insertTask function.
    * Inserts task - called from ajaxprocess.php
    * @return 1|2
    */
    public function insertTask()
    {
        $task     = !empty($_POST['inputTask']) ? $this->validate_data($_POST['inputTask']) : NULL;
        $due_date = !empty($_POST['inputDuedate']) ? $this->validate_data($_POST['inputDuedate']) : NULL;
        $due_date = !empty($due_date) ? date('Y-m-d H:i:s', strtotime($due_date)) : NULL;
        $created_date = date('Y-m-d H:i:s');
        
        if (!empty($task)) {
            
            $sql = "INSERT INTO todolist (task, due_date, created_date) VALUES ('$task', '$due_date', '$created_date')";
            if(mysqli_query($this->db, $sql)) {
                
                return 1;
            }
        }
        else {
            
            return 2;
        }
        
    }

    /**
    * deleteTask function.
    * Deletes task - called from ajaxprocess.php
    * @return 1
    */
    public function deleteTask()
    {
        $sql = "DELETE FROM todolist WHERE id=".$_GET['deltaskId'];
        
        if(mysqli_query($this->db, $sql)){
            
            return 1;
        }
    }
    
    /**
    * readTask function.
    * Edits/Reschedule a task - called from ajaxprocess.php
    * @return $row - one record
    */
    public function readTask()
    {
        $sql = "SELECT * FROM todolist WHERE id=".$_GET['edittaskId'];
        
        $result = $this->db->query($sql);
        $row = $result->fetch_assoc();
        
        return json_encode($row);
    }

    /**
    * editTask function.
    * Edits a task - called from ajaxprocess.php
    * @return 1
    */
    public function editTask()
    {
        $id       = !empty($_POST['hdnedittaskId']) ? $this->validate_data($_POST['hdnedittaskId']) : NULL;
        $task     = !empty($_POST['inputTask']) ? $this->validate_data($_POST['inputTask']) : NULL;
        $due_date = !empty($_POST['inputDuedate']) ? $this->validate_data($_POST['inputDuedate']) : NULL;
        $due_date = !empty($due_date) ? date('Y-m-d H:i:s', strtotime($due_date)) : NULL;
        $created_date = date('Y-m-d H:i:s');
        
        $sql = "UPDATE todolist SET task='$task', due_date='$due_date' WHERE id=$id";
        if(mysqli_query($this->db, $sql)) {
            
            return 1;
        }
    }
    
    /**
    * rescheduleTask function.
    * Reschedule a task - called from ajaxprocess.php
    * @return $row - one record
    */
    public function rescheduleTask()
    {
        $id       = !empty($_POST['hdnedittaskId']) ? $this->validate_data($_POST['hdnedittaskId']) : NULL;
        $due_date = !empty($_POST['inputDuedate']) ? $this->validate_data($_POST['inputDuedate']) : NULL;
        $due_date = !empty($due_date) ? date('Y-m-d H:i:s', strtotime($due_date)) : NULL;
        $created_date = date('Y-m-d H:i:s');
        
        $sql = "UPDATE todolist SET due_date='$due_date' WHERE id=$id";
        if(mysqli_query($this->db, $sql)) {
            
            return 1;
        }
    }
    
    /**
    * markCompleted function.
    * Complete a task - called from ajaxprocess.php
    * @return 1
    */
    public function markCompleted()
    {
        $id        = !empty($_POST['taskId']) ? $this->validate_data($_POST['taskId']) : NULL;
        $completed = !empty($_POST['completed']) ? $this->validate_data($_POST['completed']) : NULL;
        $completed_date = date('Y-m-d H:i:s');

        $sql = "UPDATE todolist SET is_completed =$completed, completed_date ='$completed_date' WHERE id=$id";
        
        if(mysqli_query($this->db, $sql)) {
            
            return 1;
        }
    }
    
    /**
    * validate_data function.
    * Valdates the data to be inserted - called from processtodo.php
    * @return $data - validated data
    */
    private function validate_data($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = strip_tags($data);
        $data = htmlspecialchars($data);
        
        return $data;    
    }
    
    /**
    * showDate function.
    * Format date - called from upcoming.php
    * @return $response - formated date
    */
    public function showDate($date)
    {
        $param_date = date('d-m-Y',strtotime($date));
        
        if ($param_date == date('d-m-Y',strtotime("now"))) {
            
            $response = 'Today, ' . date('g:i A', strtotime($date));
        }
        else if($param_date == date('d-m-Y',strtotime("1 days"))) {
            
            $response = 'Tommorow, '. date('g:i A', strtotime($date));
        }
        else if($param_date == date('d-m-Y',strtotime("-1 days"))) {
            
            $response = 'Yesterday'; 
        }
        else {
            
            $response =  date('D, M d, Y, g:i A', strtotime($date));
        }
        
        return $response;
    }
}
?>
