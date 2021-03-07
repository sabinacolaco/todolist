<?php
require_once 'API.php';

class ProcessAPI extends API
{
    public function __construct($request)
    {
        parent::__construct($request);        
    }

    /**
    * processAPI function.
    * Redirects to specific function
    * @return $this->_response - JSON Response
    */
    public function processAPI()
    {
        $this->task = new Task($this->db);
        
        if (!empty($_REQUEST['request'])  && !empty($_SERVER['REQUEST_METHOD'])) {    
            
            if (($_REQUEST['request'] === 'tasks') && ($_SERVER['REQUEST_METHOD'] == 'GET')) { 
    
                return $this->listcurrentTasks();
            } 
            else if (($_REQUEST['request'] === 'addtask') && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
                
                return $this->addTask();
            }
            else if (($_REQUEST['request'] === 'edittask') && ($_SERVER['REQUEST_METHOD'] == 'PUT') && (!empty($_REQUEST['id']))) {
                
                return $this->editTask();
            }
            else if (($_REQUEST['request'] === 'deletetask') && ($_SERVER['REQUEST_METHOD'] == 'DELETE')) {
                
                return $this->deleteTask();
            }
        }
        
        return $this->_response(array("status" => "error", "message" => "Wrong Endpoint", 404));
    }
    
    /**
    * listcurrentTasks function.
    * List current tasks
    * @return $this->_response - JSON Response
    */
    protected function listcurrentTasks()
    {
        $stmt = $this->task->read();
        $num = $stmt->rowCount();
        
        if ($num>0) {
            
            $task_arr = [];
            $task_arr["records"] = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $task_record=array(
                    "id" => $id,
                    "task" => $task,
                    "due_date" => $this->showDate($due_date),
                    "is_completed" => ($is_completed == 1) ? 'Yes' : 'No',
                );
                array_push($task_arr["records"], $task_record);
            }
            
            return $this->_response(array("status" => "success", "data" => $task_arr["records"], "message" => "TO-DO Listing", 200));
        }
        
        return $this->_response(array("status" => "error","message" => "No data available", 500));
    }
    
    /**
    * addTask function.
    * Calls insertTask to insert the data
    * @return $this->_response - JSON Response
    */
    protected function addTask()
    {
        $data = json_decode(file_get_contents("php://input"));
        $this->task->task = $data->task;
        $this->task->due_date = $data->due_date;
        
        if(empty(trim($this->task->task)))
        
            return $this->_response(array("status" => "error", "message" => "Data not proper, you need to enter task", 500));
        
        if ($this->task->insertTask()) {
            
            return $this->_response(array("status" => "success", "message" => "Task has been added successfully."), 200);
        }
        
        return $this->_response(array("status" => "error", "message" => "Task not added", 500));
    }
    
    /**
    * editTask function.
    * Calls updateTask to update the data
    * @return $this->_response - JSON Response
    */
    protected function editTask()
    {
        $data = json_decode(file_get_contents("php://input"));
        
        if (!empty($_REQUEST['id'])) {
            
            $this->task->task = $data->task;
            $this->task->due_date = $data->due_date;
            $this->task->id = $_REQUEST['id'];
            
            if(empty(trim($this->task->task)))
                
                return $this->_response(array("status" => "error", "message" => "Data not proper, you need to enter task", 500));
            
            if ($this->task->updateTask()) {
                
                return $this->_response(array("status" => "success", "message" => "Task has been updated successfully"), 200);
            }
            
            return $this->_response(array("status" => "error", "message" => "Data is not proper, invalid task id"), 500);
        }
        
        return $this->_response(array("status" => "error", "message" => "Data missing", 500));
    }
    
    /**
    * deletetask function.
    * Calls deleteTask to delete the data
    * @return $this->_response - JSON Response
    */
    protected function deletetask()
    {
        $data = json_decode(file_get_contents("php://input"));
        
        if (!empty($data->id)) {      
            $this->task->id = $data->id;
        
            if ($this->task->deleteTask()) {
                
                return $this->_response(array("status" => "success", "message" => "Task has been deleted successfully"), 200);
            }

            return $this->_response(array("status" => "error", "message" => "Data is not proper, invalid task id"), 500);
        }
          
        return $this->_response(array("status" => "error", "message" => "Data missing", 500));
    }
    
    /**
    * showDate function.
    * Formats the date
    * @return $response
    */
    private function showDate($date)
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