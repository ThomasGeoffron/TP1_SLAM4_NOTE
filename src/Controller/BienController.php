<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Bien;
use App\Form\BienType;
use App\Form\UpdateBienType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class BienController extends AbstractController
{
    /**
     * @Route("/bien/add", name="AjoutBien")
     */
    public function creerBien(Request $query){
        
        $bien = new Bien();
        $form = $this->createForm(BienType::class, $bien);
        
        $form->handleRequest($query);
        
        if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $data = $form->getData();      
                
                $nbPiece = $form['nb_piece']->getData();
                $nbChambre = $form['nb_chambre']->getData();
                $superficie = $form['superficie']->getData();
                $prix = $form['prix']->getData();
                $chauffage = $form['chauffage']->getData();
                $annee = $form['annee']->getData();
                $localisation = $form['localisation']->getData();
                $etat = $form['etat']->getData();
                $type = $form['type']->getData();
                

                
                $bien->setNbPiece($nbPiece);
                $bien->setNbChambre($nbChambre);
                $bien->setSuperficie($superficie);
                $bien->setPrix($prix);
                $bien->setChauffage($chauffage);
                $bien->setAnnee($annee);
                $bien->setLocalisation($localisation);
                $bien->setEtat($etat);
                $bien->setType($type);
                
                $em->persist($bien);
                $em->flush();
                
                $query->getSession()
                    ->getFlashBag()
                    ->add('success','Bien ajouté avec succès');
                
                return $this->redirectToRoute('AjoutBien');
        }
        return $this->render('bien/bienAjout.html.twig',array('form'=>$form->createView(),));
        
    }
    
    /**
      *
      *@Route("/bien/autre",name="affiBien")
      *
      */
    public function indexAction(Session $session){
        $id = $session->get('id');
        $repository = $this->getDoctrine()->getManager()->getRepository(Bien::class);
        $bien = $repository->findAll();
        return $this->render('bien/listeBien.html.twig', array('biens'=>$bien));
    }
    
    /**
      *
      *@Route("/bien/delete/{id}",name="deleteBien")
      *
      */
    public function deleteVisiteur(Session $session, $id){
        $bien = $this->getDoctrine()->getManager()->getRepository(Bien::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($bien);
        $em->flush();
        return $this->redirectToRoute('affiBien');
    }
    
    /**
    *
    *@Route("/bien/update/{id}",name="upd_bien")
    *
    */
    public function updateBien(Request $request, Session $session, $id){
        $bien = new Bien() ;
        $bien = $this->getDoctrine()->getManager()->getRepository(Bien::class)->find($id);
        //$id = $session->get('login');
        $request->getSession()->getFlashBag()->add('notice', '');
        $form = $this->createForm(UpdateBienType::class, $bien);
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Bien modifié avec succès.');

                return $this->redirectToRoute('upd_bien',array('id'=>$id));
            }
        }

        return $this->render( 'bien/bienUpdate.html.twig', array('form' =>$form->createView(), 'bien'=>$bien));
    }
    
    /**
     * @Route("/bien/afficheType/{id}", name="bienParType")
     */
    public function listerBienParType(Request $request, $id) {
       
        $em = $this->getDoctrine()->getManager();
        $valeur = $em->getRepository(Bien::class)->rechercherParType($id);    
        return $this->render('bien/bienParType.html.twig',array('biens'=>$valeur));
     }
}
