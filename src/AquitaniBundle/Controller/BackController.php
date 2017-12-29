<?php

namespace AquitaniBundle\Controller;

use AquitaniBundle\Entity\Chantier;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BackController extends Controller
{
     /**
     * @Route("/admin", name="backadmin")
     */
    public function HomeadminAction()
    {        
     $rep=$this->getDoctrine()->getManager()->getRepository('AquitaniBundle:Chantier');
     $chantier=$rep->findAll();       
         
     return $this->render('AquitaniBundle:Back:Index.html.twig',array('chantier'=>$chantier,));
    
    }
    /**
     * @Route("/admin/add", name="backadminadd")
     */
    public function adminaddAction(Request $request)
    {        
    $chantier= new Chantier();    
    $form = $this->createformchantier($request,$chantier);
    if ($form->isValid()){
    $form=$this->setfilename($form);  
    $this->settobase($form); 
    return $this->redirectToroute('backadmin');
     }
        
    return $this->render('AquitaniBundle:Back:Add.html.twig',array('form'=>$form->createView()));    
    }
    /**
     * @Route("/admin/del/{id}", name="backadmindel")
     */
    public function admindelAction($id)
    {        
    $em=$this->getDoctrine()->getManager()->getRepository('AquitaniBundle:Chantier');
    $rep = $em->find($id); 
    $this->deltobase($rep);        
    return $this->redirectToroute('backadmin');   
        
    }
    /**
     * @Route("/admin/edit/{id}", name="backadminedit")
     */
    public function admineditAction(Request $request,$id)
    {        
    $chantier=$this->getDoctrine()->getManager()->getRepository('AquitaniBundle:Chantier')->find($id);
    $form=$this->createformchantier($request,$chantier);
    if ($form->isValid()){
    $form=$this->setfilename($form);  
    $this->settobase($form); 
    return $this->redirectToroute('backadmin');
     }
        
    return $this->render('AquitaniBundle:Back:Add.html.twig',array('form'=>$form->createView()));     
        
    }
    
    public function createformchantier(Request $request,$chantier)
    {        
     
     $form = $this->get('form.factory')->createBuilder(FormType::class, $chantier)
             ->add('nom',TextType::class,array('label'=> false,'attr'=>array('placeholder'=>'Nom du chantier','class'=> 'btn-info  form-control')))
             ->add('datedefin',DateType::class,array('widget' => 'single_text','label'=> false,'attr'=>array('placeholder'=>'Date de fin du chantier','class'=> 'btn-info form-control')))
             ->add('description',TextareaType::class,array('label' => false,'attr'=>array('placeholder'=>'Description du chantier','class'=> 'btn-info form-control')))
             ->add('photo',FileType::class,array('label' => 'Photo du chantier','data_class' => null,'attr'=>array('placeholder'=>'Photo du  chantier','class'=> 'btn-info btn form-control')))
             ->add('activites',EntityType::class,array('label' => false,'class'=>'AquitaniBundle:Activite','choice_label'=>'nom','attr'=>array('placeholder'=>'Type du chantier','label' => false ,'class'=> 'btn btn-info form-control')))
             ->add('envoyer',SubmitType::class,array('attr'=>array('label'=> false,'class'=> 'btn btn-success form-control')))
             ->getForm();
     
     $form->handleRequest($request);
          
       return $form;    
    }  
        public function setfilename($form)
    {
        $file = $form->getData()->getPhoto();
        $filename = md5(uniqid()).'.'.$file->guessExtension();
	$file->move($this->getParameter('photo_directory'),$filename);
        $form->getData()->setPhoto($filename);
        return $form;
    }
        public function settobase($form)
    {
    $em = $this->getDoctrine()->getManager();
    $objet = $form->getData();
    $em->persist($objet);
    $em->flush(); 
    }
        
        public function deltobase($rep)
    {
    $em = $this->getDoctrine()->getManager();
    //$objet = $rep->getData();
    $em->remove($rep);
    $em->flush(); 
         
    }
}
