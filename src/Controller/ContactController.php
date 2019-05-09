<?php


namespace App\Controller;

class ContactController extends AbstractController
{

    public function index()
    {
        return $this->twig->render('Contact/contactform.html.twig');

    }

}
