<?php

namespace App\Controller;

use App\Entity\Contacts;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends AbstractController
{

    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function index()
    {
        //Võtab kõik kontaktid andmebaasist
        $contacts = $this->getDoctrine()->getRepository(Contacts::class)->findAll();
        

        return $this->render('content.html.twig', array('contacts' => $contacts));
    }

    
}