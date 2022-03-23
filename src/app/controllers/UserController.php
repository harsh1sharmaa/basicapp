<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{

    public function displayAction()
    {

        $params = $this->dispatcher->getParams();

        // print_r($params);
        $this->view->data = $params;
        // echo $params['email'];
        // die();
    }

    public function updateAction()
    {


        // echo "eherew";
        // die();

        $user = new Users();

        $user->assign(
            $this->request->getPost(),
            [
                'name',
                'email'
            ]
        );


        // echo $user->name;
        // echo $user->email;

        $objuser = Users::findByemail($user->email);


        $objuser->update(
            [
                // 'type' => 'mechanical',
                // 'name' => 'Astro Boy',
                // 'year' => 1952,
                'name' => $user->name,
                'email' => $user->email
            ]
        );
    }


    public function adminAction()
    {
        //    echo "inr admin";
        $objuser = Users::find();

        $objblog = Blogs::find();
        // echo "<pre>";
        // print_r($objuser);
        // echo "<pre>";
        // print_r($objblog);
        // print_r($objblog[0]->title);
        // die();

        $this->view->message = [$objuser, $objblog];
    }

    public function userdashAction()
    {
        $id = $_SESSION['user'];

        $objblog = Blogs::findByuser_id($id);
        $this->view->message = $objblog;
    }
}
