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
     * @Route("/new")
     * Method({"GET", "POST"})
     */

    

    public function new(Request $request)
    {
        $contact = new Contacts();
        

        $form = $this->createFormBuilder($contact)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('number', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('Add', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')), ['label' => 'Create Contact'])
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
            'form' => $form->createView(), 'name' => 'New Contact'
        ]);

        
    }

    /**
     * @Route("/update/{id}")
     * Method({"GET", "POST"})
     */

    public function update(Request $request, $id) {
        $contact = new Contacts();
        $contact = $this->getDoctrine()->getRepository(Contacts::class)->find($id);
        

        $form = $this->createFormBuilder($contact)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('number', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('update', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')), ['label' => 'Update'])
            ->getForm();
            
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            

            $entityManager = $this->getDoctrine()->getManager();            
            $entityManager->flush();

            return $this->redirectToRoute('mainpage');
        }
        

        return $this->render('new.html.twig', array(
            'form' => $form->createView(), 'name' => 'Update'
          ));
      }

    /**
     * @Route("/delete/{id}")
     * @Method({"DELETE"})
     */

    public function delete(Request $request, $id){

        $contact = $this->getDoctrine()->getRepository(Contacts::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($contact);
        $entityManager->flush();

        $response = new Response();
        $response->send();

        
    }

    
}