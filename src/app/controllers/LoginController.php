<?php

if (!isset($_SESSION['user'])) {
    session_start();
}

use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
    public function indexAction()
    {
        //return '<h1>Hello!!!</h1>';
    }

    public function loginuserAction()
    {


        $user = new Users();

        $user->assign(
            $this->request->getPost(),
            [
                'name',
                'email'
            ]
        );

        // print_r($user);
        // $user = $this->models("Users");
        $name = $user->name;
        $email = $user->email;
        $user = Users::find("name = '$name'");
        $user2 = Users::find("email = '$email'");

        $id = $user[0]->user_id;
        $id2 = $user2[0]->user_id;




        // $nemail = $user[0]->email;
        if ($id == $id2 && $user[0]->permission == 'yes') {

            $role = $user[0]->role;
            if ($role == 'admin') {

                // echo "ed";

                $_SESSION['user'] = $id;
                $this->dispatcher->forward(
                    [
                        'controller' => 'user',
                        'action'     => 'admin'
                    ]
                );
            } else {
                //   echo "cos";
                  $_SESSION['user'] = $id;
                  $this->dispatcher->forward(
                      [
                          'controller' => 'user',
                          'action'     => 'userdash'
                      ]
                  );

                // $this->view->message = ["email" => $email, "name" => $name];
                // $this->dispatcher->forward(
                //     [
                //         'controller' => 'User',
                //         'action'     => 'userdash',
                //         'params' => ["name" => $name, "email" => $email]
                //     ]
                // );
            }
        } else {

            $this->view->message = "invalid email";
            // header('Location: ./login');



        }
    }

    public function changePermissionAction($id, $permission)
    {
        // echo $id;
        // echo $permission;

        $objuser = Users::findByuser_id($id);


        $objuser->update(
            [
                // 'type' => 'mechanical',
                // 'name' => 'Astro Boy',
                // 'year' => 1952,
                'permission' => $permission

            ]
        );

        header('Location: /user/admin');


        die();
    }
    public function changeBlogPermissionAction($id, $permission)
    {

        // echo $id;
        // echo $permission;

        $objblog = Blogs::findByblog_id($id);


        $objblog->update(
            [

                'permission' => $permission

            ]
        );

        header('Location: /user/admin');

        // echo "changeBlogPermission";
        die();
    }
}
