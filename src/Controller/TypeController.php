<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Type;
use App\Form\TypeType;
use App\Form\UpdateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class TypeController extends AbstractController
{
    /**
     * @Route("/type/add", name="AjoutType")
     */
    public function creerType(Request $query){
        
        $type = new Type();
        $form = $this->createForm(TypeType::class, $type);
        
        $form->handleRequest($query);
        
        if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $data = $form->getData();      
                
                $nom = $form['libelle']->getData();
                
                $type->setLibelle($nom);
                
                $em->persist($type);
                $em->flush();
                
                $query->getSession()
                    ->getFlashBag()
                    ->add('success','Type ajouté avec succès');
                
                return $this->redirectToRoute('AjoutType');
        }
        return $this->render('type/typeAjout.html.twig',array('form'=>$form->createView(),));
        
    }
    
    /**
      *
      *@Route("/type/autre",name="affiType")
      *
      */
    public function indexAction(Session $session){
        $id = $session->get('id');
        $repository = $this->getDoctrine()->getManager()->getRepository(Type::class);
        $type = $repository->findAll();
        return $this->render('type/listeType.html.twig', array('types'=>$type));
    }
    
    /**
    *
    *@Route("/type/update/{id}",name="upd_type")
    *
    */
    public function updateType(Request $request, Session $session, $id){
        $type = new Type() ;
        $type = $this->getDoctrine()->getManager()->getRepository(Type::class)->find($id);
        //$id = $session->get('login');
        $request->getSession()->getFlashBag()->add('notice', '');
        $form = $this->createForm(UpdateType::class, $type);
        
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Visiteur modifié avec succès.');

                return $this->redirectToRoute('upd_type',array('id'=>$id));
            }
        }

        return $this->render( 'type/typeUpdate.html.twig', array('form' =>$form->createView(), 'type'=>$type));
    }
    
    /**
      *
      *@Route("/type/delete/{id}",name="deleteType")
      *
      */
    public function deleteType(Session $session, $id){
        $type = $this->getDoctrine()->getManager()->getRepository(Type::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($type);
        $em->flush();
        return $this->redirectToRoute('affiType');
    }
}
