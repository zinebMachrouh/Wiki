<?php
class Users extends Controller
{
    private $userModel;
    private $wikiModel;
    private $categoryModel;
    private $tagModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->wikiModel = $this->model('Wiki');
        $this->categoryModel = $this->model('Category');
        $this->tagModel = $this->model('Tag');
    }

    public function index()
    {
        $_SESSION['auth'] = false;
        $data = [
            'wikis' => $this->wikiModel->getAll(),
            'categories' => $this->categoryModel->getAll(),
            'tags' => $this->tagModel->getAll(),
        ];
        $this->view('users/dashboards/visitor', $data);
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

                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser && preg_match($emailP, $data['email']) && preg_match($pswdP, $data['password'])) {
                    $this->createUserSession($loggedInUser);
                    redirect('users/dashboard');
                } else {
                    echo '<script>alert("Info incorrect")</script>';

                    $this->view('users/index', $data);
                }
            } else {
                echo '<script>alert("No user found")</script>';
            }
        } else {

            $this->view('users/index');
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
                'password' => (preg_match($passwordRegex, $_POST['password']) ? password_hash(trim($_POST['password']), PASSWORD_BCRYPT) : false),
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
        $_SESSION['auth'] = true;
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

        $dataV= [
            'wikis' => $this->wikiModel->getAll(),
            'categories' => $this->categoryModel->getAll(),
            'tags' => $this->tagModel->getAll(),

        ];

        if ($_SESSION['auth']) {
            $data = $dataV + [
                'user' => $this->userModel->getUserById($_SESSION['user_id']),
            ];
            if ($data['user']->role === 0) {
                $this->view('users/dashboards/user', $data);
            } else {
                $this->view('users/dashboards/admin', $data);
            }
        }else{
            $this->view('users/dashboards/visitor',$dataV);
        }
    }

    public function profile()
    {
        $data = [
            'wikis' => $this->wikiModel->getWikisByUserId(),
            'user' => $this->userModel->getUserById($_SESSION['user_id']),
        ];

        $this->view('users/profile', $data);
    }
}
