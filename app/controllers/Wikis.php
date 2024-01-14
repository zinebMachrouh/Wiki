<?php
class Wikis extends Controller
{
    private $wikiModel;
    private $categoryModel;
    private $tagModel;

    public function __construct()
    {
        $this->wikiModel = $this->model('Wiki');
        $this->categoryModel = $this->model('Category');
        $this->tagModel = $this->model('Tag');
    }
    public function addWiki()
    {
        $data = [
            'categories' => $this->categoryModel->getCats(),
            'tags' => $this->tagModel->getTags(),
        ];
        $this->view('wikis/addWiki', $data);
    }
    public function insertData()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
            'title' => trim($_POST['title']),
            'content' => trim($_POST['content']),
            'category_id' => trim($_POST['category']),
            'tags' => isset($_POST['tag']) ? $_POST['tag'] : [],
        ];


        $lastId = $this->wikiModel->Add($data);
        foreach ($data['tags'] as $tag) {
            $this->wikiModel->attachTag($lastId, $tag);
        }

        redirect('users/profile');
    }
    public function deleteOne($id)
    {
        $this->wikiModel->Delete($id);
        redirect('users/profile');
    }
    public function archive($id)
    {
        $this->wikiModel->Archive($id);
        redirect('users/dashboard');
        
    }

    public function updateForm($id)
    {
        $data = [
            'categories' => $this->categoryModel->getCats(),
            'wiki' => $this->wikiModel->getWiki($id),
            'tags' => $this->tagModel->getTagsNotInWikis($id),
            'tagsWiki' => $this->tagModel->getTagByWikiId($id),
        ];
        $this->view('wikis/modifyWiki', $data);
    }
    public function modifyData($id){
        $data = [
            'title' => trim($_POST['title']),
            'content' => trim($_POST['content']),
            'category_id' => trim($_POST['category']),
            'tags' => isset($_POST['tag']) ? $_POST['tag'] : [],
        ];

        $this->wikiModel->Update($data['title'], $data['content'], $data['category_id'], $id);
        $this->wikiModel->updateTags($id, $data['tags']);

        redirect('users/profile');

    }

    public function wikiDetails($id)
    {
        $data = [
            'wiki' => $this->wikiModel->getWiki($id),
            'tags' => $this->tagModel->getTagByWikiId($id),
            'category' => $this->categoryModel->getOne($this->wikiModel->getWiki($id)->category_id),
        ];
        $this->view('wikis/details', $data);

    }
    public function searchData($param){
        $results =  $this->wikiModel->searchData($param);
        echo json_encode($results);
    }
    public function setPicture($picture){
        $valid_extensions = array('jpeg', 'jpg', 'png');
        $path = APPROOT . "/../public/uploads/";

        $img = $_FILES['picture']['name'];
        $tmp = $_FILES['picture']['tmp_name'];

        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

        $picture = rand(1000, 1000000) . $img;

        if (in_array($ext, $valid_extensions)) {
            $path = $path . strtolower($picture);
            if (!move_uploaded_file($tmp, $path)) {
                $data['picture_err'] = 'Picture upload unsuccessful';
            }
        } else {
            $data['picture_err'] = 'Unsupported extension';
        }
    }
}
