<?php
class Tags extends Controller
{
    private $userModel;
    private $tagModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->tagModel = $this->model('Tag');
    }

    public function index()
    {
        $data = [
            'tags' => $this->tagModel->adminTags(),
            'user' => $this->userModel->getUserById($_SESSION['user_id']),
        ];

        $this->view('tags', $data);
    }

    public function addOne()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $newData = [
            'title' => $_POST['title'],
        ];
        $this->tagModel->Add($newData);
        redirect('tags/index');
    }

    public function modifyOne()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $newData = [
            'id' => $_POST['id'],
            'title' => $_POST['modTitle'],
        ];
        $this->tagModel->Update($newData);
        redirect('tags/index');
    }

    public function deleteOne($id)
    {
        $this->tagModel->Delete($id);
        redirect('tags/index');
    }
}
