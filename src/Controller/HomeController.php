<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\ArticleManager;
use App\Model\EvenementsManager;
use App\Model\UserManager;

class HomeController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $userManager=new UserManager();
        $users=$userManager->selectAll();

        $ArticleManager=new ArticleManager();
        $articles=$ArticleManager->selectAll();

        $evenementsManager= new EvenementsManager();
        $evenements=$evenementsManager->selectAll();


        return $this->twig->render('Home/index.html.twig', ['users'=>$users,
            'articles'=>$articles,
            'evenements'=>$evenements]);
    }
}
