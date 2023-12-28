<?php
interface Data1{
     public function __construct();
     public function insertUser($username, $email, $password);
     public function updateUser($id, $username, $email, $password);
 
}
interface Data2{
     public function deleteUser($id);
     public function getUsers();
     public function getUserById($id);
     public function closeConnection();
    

    }

class Data implements Data1,Data2{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "project1";
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

    }

    public function insertUser($username, $email, $password)
    {
        $query = "INSERT INTO user1 (username, email, password)
                    VALUES ('$username', '$email', '$password')";
        $this->conn->query($query);
    }

    public function updateUser($id, $username, $email, $password)
    {
        $query = "UPDATE user1 SET username='$username', email='$email', password='$password' WHERE id=$id";
        $this->conn->query($query);
    }

    public function deleteUser($id)
    {
        $query = "DELETE FROM user1 WHERE id=$id";
        $this->conn->query($query);
    }
    //read
    public function getUsers()
    {
        $query = "SELECT * FROM user1";
        $result = $this->conn->query($query);
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

    public function getUserById($id)
    {
        $query = "SELECT * FROM user1 WHERE id=$id";
        $result = $this->conn->query($query);

        return $result->fetch_assoc();
    }

    public function closeConnection()
    {
        $this->conn->close();
    }
}


?>