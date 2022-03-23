<?php

session_start();

use Phalcon\Mvc\Controller;


class BlogController extends Controller
{
    public function getblogAction()
    {

        $blogobj = Blogs::find();

        $this->dispatcher->forward(
            [
                'controller' => 'user',
                'action'     => 'admin',
                'params' => ['blog' => $blogobj]
            ]
        );
    }

    public function readmoreAction($id)
    {

        // echo $id;
        // die();
        $objblog = Blogs::findByblog_id($id);


        $this->view->message = ["title" => $objblog[0]->title, "text" => $objblog[0]->text];
    }

    public function displayblogAction()
    {
        // echo "hello";


        $blogobj = Blogs::findBypermission("yes");
        // print_r($blogobj[0]->text);
        // die();

        $this->view->message = $blogobj;

        // die();
    }

    public function uploadAction()
    {
    }
    public function uploadingAction()
    {

        $user_id = $_SESSION['user'];
        // die();

        $blog = new Blogs();

        $blog->assign(
            $this->request->getPost(),
            [
                'title',
                'text',


            ]
        );
        $blog->user_id = $user_id;
        $blog->save();

        header('Location: /blog/upload');

        // echo "<pre>";
        // print_r($blog);
        // die();
    }
}
