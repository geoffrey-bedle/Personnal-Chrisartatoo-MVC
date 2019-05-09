<?php


namespace App\Controller;

use App\Model\UserManager;

class LoginController extends AbstractController
{
    public function login()
    {
        if (isset($_POST['submit'])) {
            $userManager = new UserManager();
            $user = $userManager->selectByEmail($_POST);

            if (isset($user[0]['email'])) {
                if ($_POST['password'] == $user[0]['password']) {
                    $_SESSION['id'] = $user[0]['id'];
                    $_SESSION['firstname'] = $user[0]['firstname'];
                    $_SESSION['lastname'] = $user[0]['lastname'];
                    $_SESSION['email'] = $user[0]['email'];
                    $_SESSION['status'] = $user[0]['status'];
                    header('Location:/');
                } else {
                    echo 'E-mail ou mot de passe incorrect.';
                }
            } else {
                echo 'E-mail ou mot de passe incorrect.';
            }
        }
        return $this->twig->render('Login/login.html.twig');
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location:/');
    }
}
