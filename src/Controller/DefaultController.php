<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function index()
    {
        $title = "Symfony App";

        return $this->render('base.html.twig', [
            'title' => $title,
        ]);
    }
}