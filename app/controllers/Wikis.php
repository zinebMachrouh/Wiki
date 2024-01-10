<?php
class Wikis extends Controller
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
    public function addWiki(){
        $data = [
            'categories'=> $this->categoryModel->getCats(),
            'tags'=> $this->tagModel->getTags(),
        ];
        $this->view('wikis/addWiki',$data);
    }
    public function insertData(){
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data=[
            'title'=> trim($_POST['title']),
            'content'=> trim($_POST['content']),
            'category_id'=> trim($_POST['category']),
            'tags'=> isset($_POST['tag']) ? $_POST['tag'] : [],
        ];


        $lastId = $this->wikiModel->Add($data);
        foreach ($data['tags'] as $tag) {
            $this->wikiModel->attachTag($lastId,$tag);
        }
    }
}