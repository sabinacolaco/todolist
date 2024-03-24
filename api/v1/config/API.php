<?php
include_once './config/Database.php';
include_once './models/Task.php';

abstract class API
{
    protected $method = '';
    protected $endpoint = '';
    protected $db;
    protected $customer;
    protected $task = [];
    
    public function __construct($request)
    {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->customer = new Task($this->db);
        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {  
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Unexpected Header");
            }
        }
    }
 
    abstract protected function processAPI();
    
    protected function _response($data, $status = 200)
    {
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        return json_encode($data);
    }
    
    protected function _requestStatus($code)
    {
        $status = array(
            200 => 'OK',
            201 => 'No Content',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        
        return ($status[$code])?$status[$code]:$status[500]; 
    }
}
?>
