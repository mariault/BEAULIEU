<?php

namespace AquitaniBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swift_Attachment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FrontController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function HomeAction(Request $request)
    {
    $form=$this->createformemail($request);
    if ($form->isValid() && $form->isSubmitted()){
    $this->sendemail($form);
    return $this->redirectToroute('index');
    }
    $chantier=$this->getDoctrine()->getManager()->getRepository('AquitaniBundle:Chantier')->findAll();    
    return $this->render('AquitaniBundle:Front:Index.html.twig',array('chantier'=>$chantier,'form'=>$form->createView()));
        
    }
    public function createformemail($request)
    {
        $data=array('1'=>'nom');
         $form = $this->createFormBuilder($data)
             ->add('nom',TextType::class,array('label'=> false,'attr'=>array('placeholder'=>'Votre Nom','class'=> 'btn-info  form-control')))
             ->add('email',EmailType::class,array('label'=> false,'attr'=>array('placeholder'=>'Votre Email','class'=> 'btn-info form-control')))
             ->add('telephone',TextType::class,array('label' => false,'attr'=>array('placeholder'=>'Votre numéro de Téléphone','class'=> 'btn-info form-control')))
             //->add('photo',FileType::class,array('label' => 'Vous pouvez joindre un fichier ','data_class' => null,'attr'=>array('placeholder'=>'Ajouter un fichier','class'=> 'btn-info btn form-control')))
             ->add('message',TextareaType::class,array('label' => false,'attr'=>array('placeholder'=>'Laissez ici votre message, nous le traiterons dans les lus bref délais.','label' => false ,'class'=> ' btn-info form-control')))
             ->add('envoyer',SubmitType::class,array('attr'=>array('label'=> false,'class'=> 'btn btn-success form-control')))
             ->getForm();
     
     $form->handleRequest($request);    
    return $form;
    } 
        public function sendemail( $form)
    {
    //$email=$form->get('email')->getData();         
    //var_dump($email);
     $message = \Swift_Message::newInstance()
    ->setSubject('Vous avez un message de :'.$form->get('nom')->getData())
    ->setFrom('contact@assterisk.fr')
    ->setTo('contact@assterisk.fr')
    //->setTo($form->get('email')->getData())

    ->setBody($form->get('message')->getData());

     $this->get('mailer')->send($message);
    
    
    return $message;
    } 
}
