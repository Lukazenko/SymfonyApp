<?php

namespace App\Controller;

use App\Entity\Contacts;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="mainpage")
     * @Method({"GET", "POST"})
     */
    public function index()
    {
        //Võtab kõik kontaktid andmebaasist
        $contacts = $this->getDoctrine()->getRepository(Contacts::class)->findAll();
        

        return $this->render('content.html.twig', array('contacts' => $contacts));
    }

    /**
     * @Route("/new", name="new contact")
     * Method({"GET", "POST"})
     */

    

    public function new(Request $request)
    {
        $contact = new Contacts();
        

        $form = $this->createFormBuilder($contact)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('number', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')), ['label' => 'Create Contact'])
            ->getForm();
            
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('mainpage');
        }
        

        return $this->render('new.html.twig', [
            'form' => $form->createView(),
        ]);

        
    }

    
}