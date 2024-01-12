<?php
class Categories extends Controller
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
        $data = [
            'categories' => $this->categoryModel->getArchived(),
            'user' => $this->userModel->getUserById($_SESSION['user_id']),
        ];

        $this->view('categories', $data);
    }

    public function addOne()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $newData = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
        ];
        $this->categoryModel->Add($newData);
        redirect('categories/index');
    }

    public function modifyOne()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $newData = [
            'id' => $_POST['id'],
            'title' => $_POST['modTitle'],
            'description' => $_POST['modDescription'],
        ];
        $this->categoryModel->Update($newData);
        redirect('categories/index');
    }

    public function deleteOne($id){
        $this->categoryModel->Delete($id);
        redirect('categories/index');

    }
}
