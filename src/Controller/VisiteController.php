<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\VisiteType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Visite;
use Symfony\Component\HttpFoundation\Session\Session;

class VisiteController extends AbstractController
{
    /**
     * @Route("/visite/add", name="AjoutVisite")
     */
    public function creerVisite(Request $query){
        
        $visite = new Visite();
        $form = $this->createForm(VisiteType::class, $visite);
        
        $form->handleRequest($query);
        
        if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $data = $form->getData();      
                
                $suite = $form['suite']->getData();
                $date = $form['date']->getData();
                $bien = $form['bien']->getData();
                $visiteur = $form['visiteur']->getData();
                
                $visite->setSuite($suite);
                $visite->setDate($date);
                $visite->setBien($bien);
                $visite->setVisiteur($visiteur);
                
                $em->persist($visite);
                $em->flush();
                
                $query->getSession()
                    ->getFlashBag()
                    ->add('success','Visite ajoutée avec succès');
                
                return $this->redirectToRoute('AjoutVisite');
        }
        return $this->render('visite/visiteAjout.html.twig',array('form'=>$form->createView(),));
        
    }
    
    /**
      *
      *@Route("/visite/autre",name="affiVisite")
      *
      */
    public function indexAction(Session $session){
        $id = $session->get('id');
        $repository = $this->getDoctrine()->getManager()->getRepository(Visite::class);
        $visite = $repository->findAll();
        return $this->render('visite/listeVisite.html.twig', array('visites'=>$visite));
    }
    
    /**
      *
      *@Route("/visite/delete/{id}",name="deleteVisite")
      *
      */
    public function deleteVisiteur(Session $session, $id){
        $visite = $this->getDoctrine()->getManager()->getRepository(Visite::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($visite);
        $em->flush();
        return $this->redirectToRoute('affiVisite');
    }
}
