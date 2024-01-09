<?php
class Users extends Controller
{
    private $userModel;


    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function getUserModel()
    {
        return $this->userModel;
    }


    public function index()
    {
        $this->view('users/dashboards/visitor');
    }

    //Authentication Methods
    public function signupPage()
    {
        $this->view('users/signup');
    }

    public function loginPage()
    {
        $this->view('users/index');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $emailP = "/^[a-zA-Z0-9.-_]+@[a-zA-Z]+\.[a-z]{2,}$/";
            $pswdP = "/^[A-Za-z\d]{8,}$/";

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
            ];

            if ($this->userModel->findUserByEmail($data['email'])) {
                echo '<script>alert("' . var_dump($data) . '")</script>';

                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                var_dump($loggedInUser);
                if ($loggedInUser && preg_match($emailP, $data['email']) && preg_match($pswdP, $data['password'])) {
                    $this->createUserSession($loggedInUser);
                    redirect('users/dashboard');
                } else {
                    echo '<script>alert("'.var_dump($data).'")</script>';

                    $this->view('users/index', $data);
                }
            } else {
                echo '<script>alert("No user found")</script>';
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
            ];

            $this->view('users/index', $data);
        }
    }
    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $nameRegex = "/^[a-zA-Z'-]+$/";
            $emailRegex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
            $passwordRegex = "/^[a-zA-Z0-9!@#$%^&*()_+]+$/";

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'fname' => (preg_match($nameRegex, $_POST['fname']) ? trim($_POST['fname']) : false),
                'lname' => (preg_match($nameRegex, $_POST['lname']) ? trim($_POST['lname']) : false),
                'email' => (preg_match($emailRegex, $_POST['email']) ? trim($_POST['email']) : false),
                'password' => (preg_match($passwordRegex, $_POST['password']) ? password_hash(trim($_POST['password']), PASSWORD_DEFAULT) : false),
            ];

            $this->userModel->insertData($data['fname'], $data['lname'], $data['email'], $data['password']);
            $loggedInUser = $this->userModel->getUser($data['email']);

            $this->createUserSession($loggedInUser);
            redirect('users/dashboard');
        }
    }
    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        session_destroy();
        redirect('users/index');
    }

    // Dashboard
    public function dashboard()
    {
        $this->view('users/dashboards/user');

    }
}
