<?php
session_start();

class User
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }

    function getUser($email)
    {
        try {
            $query = "SELECT * FROM users WHERE email = :email";
            $this->conn->query($query);
            $this->conn->bind(':email', $email);
            return $this->conn->single();
        } catch (PDOException $e) {
            echo '<script> alert("' . $e->getMessage() . '")</script>';
            return null;
        }
    }
    function getUserById($id)
    {
        try {
            $query = "SELECT * FROM users WHERE id = :id";
            $this->conn->query($query);
            $this->conn->bind(':id', $id);
            return $this->conn->single();
        } catch (PDOException $e) {
            echo '<script> alert("' . $e->getMessage() . '")</script>';
            return null;
        }
    }
    public function insertData($fname, $lname, $email, $service, $tel, $password)
    {
        try {
            $query = "INSERT INTO users (fname, lname, email, service, tel, password) VALUES (:fname, :lname, :email, :service, :tel, :password)";
            $this->conn->query($query);

            $this->conn->bind(':fname', $fname);
            $this->conn->bind(':lname', $lname);
            $this->conn->bind(':email', $email);
            $this->conn->bind(':service', $service);
            $this->conn->bind(':tel', $tel);
            $this->conn->bind(':password', $password);

            $this->conn->execute();
        } catch (PDOException $e) {
            echo '<script> alert("' . $e->getMessage() . '")</script>';
        }
    }

    public function storeSession($email)
    {
        $_SESSION['email'] = $email;
    }

    public function modifyData($id, $newData)
    {
        try {
            $query = "UPDATE users SET fname = :fname, lname = :lname, service = :service, tel = :tel WHERE email = :id";
            $this->conn->query($query);

            $this->conn->bind(':id', $id);
            $this->conn->bind(':fname', $newData['fname']);
            $this->conn->bind(':lname', $newData['lname']);
            $this->conn->bind(':service', $newData['service']);
            $this->conn->bind(':tel', $newData['tel']);

            $this->conn->execute();
            header("Location: dashboard.php");
        } catch (PDOException $e) {
            echo '<script> alert("' . $e->getMessage() . '")</script>';
        }
    }

    public function login($email, $password)
    {
        $this->conn->bind(':email', $email);

        $row = $this->conn->single();

        if ($row && property_exists($row, 'password')) {
            $stored_password = base64_decode($row->password);

            if ($password === $stored_password) {
                return $row;
            }
        }

        return false;
    }

    public function findUserByEmail($email)
    {
        $this->conn->query('SELECT * FROM users WHERE email = :email');
        $this->conn->bind(':email', $email);

        $this->conn->execute();

        if ($this->conn->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function updateUser($id, $fname, $lname, $birthdate, $service, $adress, $tel, $email, $pswd)
    {
        $pswd = base64_encode($pswd);

        $this->conn->query("UPDATE users 
                                    SET 
                                        `lname` = :lname, 
                                        `fname` = :fname, 
                                        `birthdate` = :birthdate, 
                                        `service` = :service, 
                                        `adress` = :adress, 
                                        `tel` = :tel, 
                                        `email` = :email, 
                                        `password` = :pswd 
                                    WHERE `id` = :id");

        $this->conn->bind(':lname', $lname);
        $this->conn->bind(':fname', $fname);
        $this->conn->bind(':birthdate', $birthdate);
        $this->conn->bind(':service', $service);
        $this->conn->bind(':adress', $adress);
        $this->conn->bind(':tel', $tel);
        $this->conn->bind(':email', $email);
        $this->conn->bind(':pswd', $pswd);
        $this->conn->bind(':id', $id);

        $this->conn->execute();
    }

    public function deleteUser($id)
    {
        $query = "DELETE FROM users WHERE id = :userId";
        $this->conn->query($query);
        $this->conn->bind(':userId', $id, PDO::PARAM_INT);
        $this->conn->execute();
        $_SESSION = array();
        session_destroy();
    }
    //Members Dashboard Methods
    public function getUserAndTeamInfoByEmail($email)
    {
        $query = "
            SELECT
                users.*,
                team_user.team_id AS teamId,
                teams.name AS team_name,
                teams.description AS team_description
            FROM
                users
            JOIN
                team_user ON users.id = team_user.user_id
            JOIN
                teams ON team_user.team_id = teams.id
            WHERE
                users.email = :email
        ";

        $this->conn->query($query);
        $this->conn->bind(':email', $email, PDO::PARAM_STR);
        $this->conn->execute();
        $user = $this->conn->single(PDO::FETCH_ASSOC);

        return $user;
    }

    public function getUserTeamsById($userId)
    {
        $query = "SELECT team_id FROM team_user WHERE user_id = :userId";

        $this->conn->query($query);
        $this->conn->bind(':userId', $userId, PDO::PARAM_INT);
        $this->conn->execute();

        $userTeams = $this->conn->resultSet(PDO::FETCH_ASSOC);

        return $userTeams;
    }

    //Admin Dashboard Methods
    public function getUsersByAdmin($role)
    {
        $query = "SELECT * FROM users WHERE role != :role";

        $this->conn->query($query);
        $this->conn->bind(':role', $role, PDO::PARAM_INT);
        $this->conn->execute();

        return $this->conn->resultSet(PDO::FETCH_ASSOC);
    }

    public function updateRole($id, $newRole)
    {
        $this->conn->query("UPDATE users SET role = :newRole WHERE id = :userID");
        $this->conn->bind(':newRole', $newRole);
        $this->conn->bind(':userID', $id);
        $this->conn->execute();
    }

    public function getScrumMasters()
    {
        $this->conn->query("SELECT * FROM users WHERE role = 2");
        $this->conn->execute();
        return $this->conn->resultSet();
    }

    public function getProductOwners()
    {
        $this->conn->query("SELECT * FROM users where role = 1");
        $this->conn->execute();
        return $this->conn->resultSet();
    }

}
