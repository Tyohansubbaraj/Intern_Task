<?php
require 'C:/xampp/htdocs/GUVI/vendor/autoload.php';
class mysqlconnection
{
    public $servername = "localhost";
    public $username = "root";
    public $dbpassword = "";
    public $dbname = "Internship_Task";
    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->dbpassword, $this->dbname);
        if ($this->conn->connect_error) {
            echo "error";
            exit();
        }
    
    }

    public function getConnection()
    {
        return $this->conn;
    }


    // public function preparedStatement($sql_query, $binder, $param, $type)
    // {
    //     $stmt = $this->conn->prepare($sql_query);
    //     $stmt->bind_param($binder, ...$param);
    //     if ($stmt->execute() == false) {
    //         echo json_encode(['status' => 'error', 'message' => 'Statement Execution Error']);
    //         exit();
    //     } // just return the connection instead of these functions
    //     if ($type == "bind") {
    //         $stmt->bind_result($result);
    //         $stmt->fetch();
    //         $stmt->close();
    //         return $result;
    //     } elseif ($type == "get") {
    //         $result = $stmt->get_result();
    //         $stmt->close();
    //         return $result;
    //     } elseif ($type = "insert") {
    //         $result = $stmt->execute();
    //         return $result;
    //     }
    // }
    // public function close()
    // {
    //     $this->conn->close();
    // }
}

class MongoDB
{
    public $client;
    public $collection;

    public function __construct($database, $table)
    {
        $this->client = new MongoDB\Client();
        $this->collection = $this->client->$database->$table;
    }

    public function insert($data)
    {
        $this->collection->insertOne($data);
    }

    public function find($condition)
    {
        $user = $this->collection->findOne($condition);
        return $user;
    }

    public function update($condition, $updated_values)
    {
        $user = $this->collection->updateOne($condition, $updated_values);
        return $user;
    }
}

class redisconnection
{
    public $conn;

    public function __construct()
    {
        $this->conn = new Redis();
        $this->conn->connect('127.0.0.1', 6379);
    }

    public function delete($param)
    {
        $this->conn->del($param);
    }

    public function set($param, $data, $time = 3600)
    {
        $this->conn->set($param, json_encode($data));
        $this->conn->expire($param, $time);
    }
}
