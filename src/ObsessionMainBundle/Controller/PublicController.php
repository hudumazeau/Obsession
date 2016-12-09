<?php

namespace ObsessionMainBundle\Controller;

use ObsessionMainBundle\Entity\Galerie;
use ObsessionMainBundle\Entity\Mail;
use ObsessionMainBundle\Entity\Statistique;
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
        $images=$this->getDoctrine()->getManager()->getRepository('ObsessionMainBundle:ImageAccueil')->findAll();
        $this->incrementeAccueil();
        return $this->render('ObsessionMainBundle:Public:index.html.twig', array(
            'adresse'=>$this->getDoctrine()->getManager()->getRepository('ObsessionMainBundle:Adresse')->findOneBy(array('id'=>1)),
            'images'=>$images
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
        $this->incrementeSoirees();
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
        $galeries=$this->getDoctrine()->getManager()->getRepository('ObsessionMainBundle:Galerie')->findAll();
        $galeries=array_reverse($galeries);
        $this->incrementePhotos();
        return $this->render('ObsessionMainBundle:Public:photos.html.twig', array(
            'galeries'=>$galeries
        ));
    }
    /**
     * @Route("/presentation",name="presentation")
     * @Method({"GET", "POST"})
     */
    public function presentationAction()
    {
        $this->incrementePresentation();
        return $this->render('ObsessionMainBundle:Public:presentation.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/evenementiel",name="presentationEvenementiel")
     * @Method({"GET", "POST"})
     */
    public function presentationEvenementielAction()
    {
        return $this->render('ObsessionMainBundle:Public:presentationEvenementiel.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/dj",name="presentationSetDj")
     * @Method({"GET", "POST"})
     */
    public function presentationDjAction()
    {
        return $this->render('ObsessionMainBundle:Public:presentationDJ.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/location",name="presentationLocation")
     * @Method({"GET", "POST"})
     */
    public function presentationLocationAction()
    {
        return $this->render('ObsessionMainBundle:Public:presentationLocation.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/galerie/{galerie}",name="galerie")
     * @Method({"GET", "POST"})
     */
    public function galerieAction(Galerie $galerie)
    {
        return $this->render('ObsessionMainBundle:Public:gallerie.html.twig', array(
            "galerie"=>$galerie
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
        $this->incrementeContacts();
        if ($form->isSubmitted() && $form->isValid()){
            $message = \Swift_Message::newInstance()
                ->setSubject($mail->getObjet())
                ->setFrom($mail->getMail())
                ->setTo('obsessionm@hotmail.fr')
                ->setBody($mail->getMessage());
            $this->get('mailer')->send($message);
            $this->get('session')->getFlashBag()->add('info','L\'email à été envoyé' );
            return $this->redirectToRoute('contact');
        }
        return $this->render("@ObsessionMain/Public/contact.html.twig",array(
            'form'=>$form->createView(),
            'adresse'=>$adresse
        ));
    }

    /**
     *
     * @Route("/boutique", name="boutique")
     * @Method({"GET", "POST"})
     */
    public function boutiqueAction(Request $request)
    {
        return $this->render("@ObsessionMain/Public/boutique.html.twig",array(
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
        $response=new JsonResponse($text);
        $response->headers->set('Access-Control-Allow-Origin','*');
        return $response;
    }

    /**
     *
     * @Route("/ajaxPhone", name="ajax_soirees_phone")
     * @Method({"GET", "POST"})
     */
    public function ajaxAdminPhoneAction(Request $request)
    {
        $soirees=$this->getDoctrine()->getManager()->getRepository('ObsessionMainBundle:Soiree')->findFiveSoirees();
        $text=array();
        foreach ($soirees as $soiree){
            $res=array();
            $res['id']=$soiree->getId();
            $res['ville']=$soiree->getLieu()->getVille();
            $res['date']=$soiree->getDate()->format('d').' '.$this->getDoctrine()->getManager()->getRepository('ObsessionMainBundle:Mois')->findOneBy(array('id'=>$soiree->getDate()->format('m')))->getDesignation();
            $text[]=$res;
        }
        $response=new JsonResponse($text);
        $response->headers->set('Access-Control-Allow-Origin','*');
        return $response;
    }

    /**
     *
     * @Route("/ajaxGalerie/{galerie}", name="ajax_galerie")
     * @Method({"GET", "POST"})
     */
    public function ajaxGalerieAction(Galerie $galerie)
    {
        $tab = array();
        foreach ($galerie->getPhotos() as $photo){
            $image=array();
            $image["lowsrc"]="/bundles/obsessionmain/img/photosGalerie/miniature/".$photo->getChemin();
            $image["fullsrc"]="/bundles/obsessionmain/img/photosGalerie/HD/".$photo->getChemin();
            $image["description"]="";
            $image["category"]="";
            $tab[]=$image;
        }
        return new JsonResponse($tab);
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

    private function incrementeAccueil(){
        $date=new \DateTime();
        $date->setTime(null,null);
        if($this->testJourExiste($date)){
            $em=$this->getDoctrine()->getManager();
            $stat=$em->getRepository('ObsessionMainBundle:Statistique')->findBy(array('date'=>$date));
            $stat=$stat[0];
            $stat->setAccueil($stat->getAccueil()+1);
            $em->persist($stat);
            $em->flush();

        }else{
            $stat=$this->initStat($date);
            $stat->setAccueil(1);
            $em=$this->getDoctrine()->getManager();
            $em->persist($stat);
            $em->flush();
        }

    }

    private function incrementePresentation (){
        $date=new \DateTime();
        $date->setTime(null,null);
        if($this->testJourExiste($date)){
            $em=$this->getDoctrine()->getManager();
            $stat=$em->getRepository('ObsessionMainBundle:Statistique')->findBy(array('date'=>$date));
            $stat=$stat[0];
            $stat->setPresentation($stat->getPresentation()+1);
            $em->persist($stat);
            $em->flush();

        }else{
            $stat=$this->initStat($date);
            $stat->setPresentation(1);
            $em=$this->getDoctrine()->getManager();
            $em->persist($stat);
            $em->flush();
        }

    }

    private function incrementePhotos (){
        $date=new \DateTime();
        $date->setTime(null,null);
        if($this->testJourExiste($date)){
            $em=$this->getDoctrine()->getManager();
            $stat=$em->getRepository('ObsessionMainBundle:Statistique')->findBy(array('date'=>$date));
            $stat=$stat[0];
            $stat->setPhotos($stat->getPhotos()+1);
            $em->persist($stat);
            $em->flush();

        }else{
            $stat=$this->initStat($date);
            $stat->setPhotos(1);
            $em=$this->getDoctrine()->getManager();
            $em->persist($stat);
            $em->flush();
        }

    }

    private function incrementeSoirees (){
        $date=new \DateTime();
        $date->setTime(null,null);
        if($this->testJourExiste($date)){
            $em=$this->getDoctrine()->getManager();
            $stat=$em->getRepository('ObsessionMainBundle:Statistique')->findBy(array('date'=>$date));
            $stat=$stat[0];
            $stat->setSoirees($stat->getSoirees()+1);
            $em->persist($stat);
            $em->flush();

        }else{
            $stat=$this->initStat($date);
            $stat->setSoirees(1);
            $em=$this->getDoctrine()->getManager();
            $em->persist($stat);
            $em->flush();
        }

    }

    private function incrementeContacts (){
        $date=new \DateTime();
        $date->setTime(null,null);
        if($this->testJourExiste($date)){
            $em=$this->getDoctrine()->getManager();
            $stat=$em->getRepository('ObsessionMainBundle:Statistique')->findBy(array('date'=>$date));
            $stat=$stat[0];
            $stat->setContacts($stat->getContacts()+1);
            $em->persist($stat);
            $em->flush();

        }else{
            $stat=$this->initStat($date);
            $stat->setContacts(1);
            $em=$this->getDoctrine()->getManager();
            $em->persist($stat);
            $em->flush();
        }

    }

    private function testJourExiste($date){
        $res=$this->getDoctrine()->getManager()->getRepository('ObsessionMainBundle:Statistique')->findBy(array('date'=>$date));
        if(count($res)==0)
            return false;
        return true;

    }

    private function initStat($date){
        $stat=new Statistique();
        $stat->setDate($date);
        $stat->setAccueil(0);
        $stat->setPresentation(0);
        $stat->setPhotos(0);
        $stat->setSoirees(0);
        $stat->setContacts(0);
        return $stat;
    }
}
