<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\VisiteurType;
use App\Form\UpdateVisiteurType;
use App\Repository\VisiteurRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Visiteur;
use Symfony\Component\HttpFoundation\Session\Session;


class VisiteurController extends AbstractController
{
    /**
     * @Route("/visiteur/add", name="AjoutVisiteur")
     */
    public function creerVisiteur(Request $query){
        
        $visiteur = new Visiteur();
        $form = $this->createForm(VisiteurType::class, $visiteur);
        
        $form->handleRequest($query);
        
        if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $data = $form->getData();      
                
                $nom = $form['nom']->getData();
                $prenom = $form['prenom']->getData();
                $adresse = $form['adresse']->getData();
                $telephone = $form['telephone']->getData();
                
                $visiteur->setNom($nom);
                $visiteur->setPrenom($prenom);
                $visiteur->setAdresse($adresse);
                $visiteur->setTelephone($telephone);
                
                $em->persist($visiteur);
                $em->flush();
                
                $query->getSession()
                    ->getFlashBag()
                    ->add('success','Visiteur ajouté avec succès');
                
                return $this->redirectToRoute('AjoutVisiteur');
        }
        return $this->render('visiteur/visiteurAjout.html.twig',array('form'=>$form->createView(),));
        
    }
    
    /**
    *
    *@Route("/visiteur/update/{id}",name="upd_visiteur")
    *
    */
    public function updateVisiteur(Request $request, Session $session, $id){
        $visiteur = new Visiteur() ;
        $visiteur = $this->getDoctrine()->getManager()->getRepository(Visiteur::class)->find($id);
        //$id = $session->get('login');
        $request->getSession()->getFlashBag()->add('notice', '');
        $form = $this->createForm(UpdateVisiteurType::class, $visiteur);
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Visiteur modifié avec succès.');

                return $this->redirectToRoute('upd_visiteur',array('id'=>$id));
            }
        }

        return $this->render( 'visiteur/visiteurUpdate.html.twig', array('form' =>$form->createView(), 'visiteur'=>$visiteur));
    }
    
    /**
      *
      *@Route("/visiteur/delete/{id}",name="deleteVisiteur")
      *
      */
    public function deleteVisiteur(Session $session, $id){
        $visiteur = $this->getDoctrine()->getManager()->getRepository(Visiteur::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($visiteur);
        $em->flush();
        return $this->redirectToRoute('affiVisiteur');
    }
    
    /**
      *
      *@Route("/visiteur/autre",name="affiVisiteur")
      *
      */
    public function indexAction(Session $session){
        $id = $session->get('id');
        $repository = $this->getDoctrine()->getManager()->getRepository(Visiteur::class);
        $visiteur = $repository->findAll();
        return $this->render('visiteur/listeVisiteur.html.twig', array('visiteurs'=>$visiteur));
    }
    
    
    
    
}
