<?php

namespace ObsessionMainBundle\Controller;

use ObsessionMainBundle\Entity\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/")
 */
class PublicController extends Controller
{
    /**
     * @Route("/",name="index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {

        return $this->render('ObsessionMainBundle:Public:index.html.twig', array(
            'adresse'=>$this->getDoctrine()->getManager()->getRepository('ObsessionMainBundle:Adresse')->findOneBy(array('id'=>1))
        ));
    }

    /**
     * @Route("/soiree",name="soiree")
     * @Method({"GET", "POST"})
     */
    public function soireeAction()
    {
        $mois=$this->getDoctrine()->getManager()->getRepository('ObsessionMainBundle:Mois')->getFourMonths();
        $url=$this->container->getParameter('affiches_url');
        return $this->render('ObsessionMainBundle:Public:soiree.html.twig', array(
            'mois'=>$mois,
            'em'=>$this->getDoctrine()->getManager()->getRepository('ObsessionMainBundle:Soiree'),
            'affiches'=>$this->getDoctrine()->getManager()->getRepository('ObsessionMainBundle:Affiche')->findLast10(),
            'url'=>$url
        ));
    }
    

    /**
     * @Route("/photos",name="photos")
     * @Method({"GET", "POST"})
     */
    public function photosAction()
    {
        return $this->render('ObsessionMainBundle:Public:photos.html.twig', array(
            // ...
        ));
    }
    /**
     * @Route("/presentation",name="presentation")
     * @Method({"GET", "POST"})
     */
    public function presentationAction()
    {
        return $this->render('ObsessionMainBundle:Public:presentation.html.twig', array(
            // ...
        ));
    }

    /**
     *
     * @Route("/contact", name="contact")
     * @Method({"GET", "POST"})
     */
    public function contactAction(Request $request)
    {
        $adresse=$this->getDoctrine()->getManager()->getRepository('ObsessionMainBundle:Adresse')->findOneBy(array('id'=>1));
        $mail=new Mail();
        $form=$this->createForm('ObsessionMainBundle\Form\MailType',$mail);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $message = \Swift_Message::newInstance()
                ->setSubject($mail->getObjet())
                ->setFrom($mail->getMail())
                ->setTo('obsessionm@hotmail.fr')
                ->setBody($mail->getMessage());
            $result=$this->get('mailer')->send($message);
            $this->get('session')->getFlashBag()->add('info',$result);
            return $this->redirectToRoute('contact');
        }
        return $this->render("@ObsessionMain/Public/contact.html.twig",array(
            'form'=>$form->createView(),
            'adresse'=>$adresse
        ));
    }

    /**
     *
     * @Route("/ajax", name="ajax_soirees")
     * @Method({"GET", "POST"})
     */
    public function ajaxAdminAction(Request $request)
    {
        $soirees=$this->getDoctrine()->getManager()->getRepository('ObsessionMainBundle:Soiree')->findFiveSoirees();
        $text=array();
        foreach ($soirees as $soiree){
            $text[]=$soiree->getLieu()->getVille().' - '.$soiree->getDate()->format('d').' '.$this->getDoctrine()->getManager()->getRepository('ObsessionMainBundle:Mois')->findOneBy(array('id'=>$soiree->getDate()->format('m')))->getDesignation();
        }
        return new JsonResponse($text);
    }


    /**
     *
     * @Route("/test", name="test")
     * @Method({"GET", "POST"})
     */
    public function testAction(Request $request)
    {
        $message='lala';
        return $this->render("@ObsessionMain/Public/Mail/mailConfirmation.html.twig",array(
            'message'=>$message,
            'nom'=>'Dumazeau'
        ));
    }
}