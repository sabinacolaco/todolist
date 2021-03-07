<?php
class Task
{
    private $conn;
    private $table_tasks = "todolist";
      
    public $id;
    public $task;
    public $due_date;
    public $is_completed;
    public $created_date;
    
    public function __construct($db)
    {
        $this->conn = $db;
    }
    
    /**
    * read function.
    * Selects records from todolist table
    * @return $stmt
    */
    function read()
    {
        $query = "SELECT * FROM " . $this->table_tasks . " WHERE due_date >= CURRENT_DATE ORDER BY due_date";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    /**
    * insertTask function.
    * Inserts records from todolist table
    * @return true|false
    */
    function insertTask()
    {
        $this->task = !empty($this->task) ? htmlspecialchars(strip_tags($this->task)) : NULL;
        $this->due_date = !empty($this->due_date) ? htmlspecialchars(strip_tags($this->due_date)) : NULL;
        $this->due_date = !empty($this->due_date) ? date('Y-m-d H:i:s', strtotime($this->due_date)) : NULL;
        $this->created_date = date('Y-m-d H:i:s');

        $query = "INSERT INTO " . $this->table_tasks . " SET task=:task, due_date=:due_date, created_date=:created_date";
        $stmt = $this->conn->prepare($query);
                    
        $stmt->bindParam(":task", $this->task);
        $stmt->bindParam(":due_date", $this->due_date);
        $stmt->bindParam(":created_date", $this->created_date);
                
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    /**
    * updateTask function.
    * updates records from todolist table
    * @return true|false
    */    
    function updateTask()
    {
        $taskchkquery = "SELECT * FROM " . $this->table_tasks . " WHERE id = ?";
        $chkstmt = $this->conn->prepare($taskchkquery);
        $cnt = 0;
        
        if(!empty($this->id)) {
            
            $chkstmt->bindParam(1, $this->id);
            
            if($chkstmt->execute()){
                $cnt = $chkstmt->rowCount();
            }
        }
        
        if ($cnt == 1) {
            $query = "UPDATE " . $this->table_tasks . " SET 
                      task = :task,
                      due_date = :due_date
                      WHERE
                      id = :id";
    
            $stmt = $this->conn->prepare($query);
            
            $this->task = !empty($this->task) ? htmlspecialchars(strip_tags($this->task)) : NULL;
            $this->due_date = !empty($this->due_date) ? htmlspecialchars(strip_tags($this->due_date)) : NULL;
            $this->due_date = !empty($this->due_date) ? date('Y-m-d H:i:s', strtotime($this->due_date)) : NULL;
            
            $stmt->bindParam(':task', $this->task);
            $stmt->bindParam(':due_date', $this->due_date);
            $stmt->bindParam(':id', $this->id);
                        
            if ($stmt->execute()) {
                
                return true;
            }
        }
        
        return false;
    }

    /**
    * deleteTask function.
    * delete records from todolist table
    * @return true|false
    */    
    function deleteTask()
    {
        $taskchkquery = "SELECT * FROM " . $this->table_tasks . " WHERE id = ?";
        $chkstmt = $this->conn->prepare($taskchkquery);
        $cnt = 0;
        
        if(!empty($this->id)) {
            
            $chkstmt->bindParam(1, $this->id);
            
            if($chkstmt->execute()){
                $cnt = $chkstmt->rowCount();
            }
        }
        
        if ($cnt == 1) {
            $query = "DELETE FROM " . $this->table_tasks . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            
            $this->id = htmlspecialchars(strip_tags($this->id));
            
            if(!empty($this->id)) {
                
                $stmt->bindParam(1, $this->id);
                
                if($stmt->execute()){
                    return true;
                }
            }
        }
        
        return false;
    }
    
}
?>
