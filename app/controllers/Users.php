<?php
class Users extends Controller
{
    private $userModel;
    private $teamModel;
    private $projectModel;


    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->teamModel = $this->model('Team');
        $this->projectModel = $this->model('Project');
    }

    public function getProjectModel()
    {
        return $this->projectModel;
    }

    public function getUserModel()
    {
        return $this->userModel;
    }

    public function getTeamModel()
    {
        return $this->teamModel;
    }

    public function index()
    {
        $this->view('users/index');
    }

    //Authentication Methods
    public function signupPage()
    {
        $this->view('users/signup');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
            ];

            if ($this->userModel->findUserByEmail($data['email'])) {

                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                    redirect('users/dashboard');
                } else {
                    echo '<script>alert("Incorrect Password")</script>';

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
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'fname' => trim($_POST['fname']),
                'lname' => trim($_POST['lname']),
                'email' => trim($_POST['email']),
                'service' => trim($_POST['service']),
                'tel' => trim($_POST['tel']),
                'password' =>  base64_encode(trim($_POST['password'])),
            ];

            $this->userModel->insertData($data['fname'], $data['lname'], $data['email'], $data['service'], $data['tel'], $data['password']);
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
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('users/index');
    }

    //Dashboards Methods
    public function dashboard()
    {
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        if ($user->role === 0) {
            $this->memberDashboard($user);
        } else if ($user->role === 3) {
            $this->adminDashboard($user);
        } else if ($user->role === 1) {
            $this->productOwnerDashboard($user);
        } else if ($user->role === 2) {
            $this->scrumMasterDashboard($user);
        }
    }

    public function memberDashboard($user)
    {
        $teamDetails = [];
        $userAteam = $this->userModel->getUserAndTeamInfoByEmail($user->email);
        $userTeams = $this->userModel->getUserTeamsById($userAteam->id);
        foreach ($userTeams as $userTeam) {
            array_push($teamDetails, $this->teamModel->getTeamDetailsById($userTeam->team_id));
        }
        $projects = $this->projectModel->getProjectsByUserId($user->id);
        foreach ($projects as $project) {
            $productOwner = $this->projectModel->getProductOwnerById($project->productOwner);
        }

        $data = [
            'profile' => $user,
            'user' => $userAteam,
            'teamDetails' => $teamDetails,
            'projects' => $projects,
            'productOwner' => $productOwner
        ];

        $this->view('users/dashboards/dashboardMember', $data);
    }

    public function adminDashboard($user)
    {
        $users = $this->userModel->getUsersByAdmin($user->role);
        $data = [
            'user' => $user,
            'users' => $users
        ];
        $this->view('users/dashboards/dashboardAdmin', $data);
    }

    public function productOwnerDashboard($user)
    {
        $projects = $this->projectModel->getProjectsByProductOwnerId($user->id);
        $teams = $this->teamModel->getTeamsWithoutScrumMasterByUserId($user->id);
        $scrumMasters = $this->userModel->getScrumMasters();
        $data = [
            'user' => $user,
            'projects' => $projects,
            'teams' => $teams,
            'scrumMasters' => $scrumMasters
        ];
        $this->view('users/dashboards/dashboardPO', $data);
    }

    public function scrumMasterDashboard($user){
        $teams = $this->teamModel->getTeamsByScrumMasterId($user->id);
        $projects = $this->projectModel->getProjectsNotInTeams();
        $data = [
            'user' => $user,
            'projects' => $projects,
            'teams' => $teams,
        ];
        $this->view('users/dashboards/dashboardSM', $data);

    }
    //Update User Methods

    public function modificationPage($id)
    {
        $user = $this->userModel->getUserById($id);
        $data = [
            'user' => $user
        ];

        $this->view('users/modifyUser', $data);
    }
    public function modifyUser($id)
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $email = $_POST["email"];
        $birthdate = $_POST["birthdate"];
        $tel = $_POST["tel"];
        $adress = $_POST["adress"];
        $service = $_POST["service"];
        $pswd = $_POST["pswd"];

        $this->userModel->updateUser($id, $fname, $lname, $birthdate, $service, $adress, $tel, $email, $pswd);

        redirect('users/dashboard');
    }

    //Delete User Method

    public function deleteUser()
    {
        $this->userModel->deleteUser($_SESSION['user_id']);
        redirect('users/index');
    }

    //Admin Method

    public function updateRole()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $id = $_POST['userID'];
        $newRole = $_POST['newRole'];

        $this->userModel->updateRole($id, $newRole);
        redirect('users/dashboard');
    }


}
