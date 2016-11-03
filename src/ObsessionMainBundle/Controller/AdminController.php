<?php

namespace ObsessionMainBundle\Controller;

use ObsessionMainBundle\Business\Utils;
use ObsessionMainBundle\Entity\Affiche;
use ObsessionMainBundle\Entity\Galerie;
use ObsessionMainBundle\Entity\Photo;
use ObsessionMainBundle\Entity\Soiree;
use ObsessionMainBundle\Entity\Lieu;
use Symfony\Bundle\AsseticBundle\Command\AbstractCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/admin")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class AdminController extends Controller
{
    /**
     * @Route("/",name="indexAdmin")
     * @Method({"GET", "POST"})
     */
    public function adminAction(Request $request){
        return $this->render('@ObsessionMain/Admin/admin.html.twig');
    }

    /**
     * @Route("/soirees",name="ajSoiree")
     * @Method({"GET", "POST"})
     */
    public function adminAjoutSoireeAction(Request $request){
        $lesMois=$this->getDoctrine()->getManager()->getRepository('ObsessionMainBundle:Mois')->findAll();
        $annees=Utils::getAnnees($this->getDoctrine()->getManager());
        $param=array();
        foreach ($annees as $annee){
            $m=Utils::getMoisAnnee($this->getDoctrine()->getManager(),$annee);
            $mois=array();
            foreach ($m as $moi){
                $mois[$moi]=$this->getDoctrine()->getManager()->getRepository('ObsessionMainBundle:Soiree')->findByAnneeMois($annee,$moi);
            }
            $param[$annee]=$mois;
        }
        $soiree=new Soiree();
        $soiree->setDate(new \DateTime());
        $form=$this->createForm('ObsessionMainBundle\Form\SoireeType',$soiree);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($soiree);
            $em->flush();

            return $this->redirectToRoute('ajSoiree');
        }
        return $this->render('@ObsessionMain/Admin/adminAjoutSoiree.html.twig',array(
            'form'=>$form->createView(),
            'param'=>$param,
            'lesMois'=>$lesMois
            
        ));
    }

    /**
     * @Route("/affiches",name="ajAffiche")
     * @Method({"GET", "POST"})
     */
    public function adminAjoutAffichesAction(Request $request){
        $lesAffiches=$this->getDoctrine()->getManager()->getRepository('ObsessionMainBundle:Affiche')->findAll();
        $affiche=new Affiche();
        $form=$this->createForm('ObsessionMainBundle\Form\AfficheType',$affiche);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->copieAffiche($affiche,'bundles/obsessionmain/img/affiches');
            return $this->redirectToRoute('ajAffiche');
        }
        $lesAffiches=array_reverse($lesAffiches);
        return $this->render('@ObsessionMain/Admin/adminAjoutAffiche.html.twig',array(
            'form'=>$form->createView(),
            'affiches'=>$lesAffiches,
        ));
    }

    /**
     * @Route("/galeries",name="adminGalerie")
     * @Method({"GET", "POST"})
     */
    public function adminGalerieAction(Request $request){
        $lesGaleries=$this->getDoctrine()->getManager()->getRepository('ObsessionMainBundle:Galerie')->findAll();
        $galerie=new Galerie();
        $form=$this->createForm('ObsessionMainBundle\Form\GalerieType',$galerie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->copieMusique($galerie);
            $this->copieCouvertureGalerie($galerie);
            $this->copiePhotosGalerie($galerie,$_FILES['file']['tmp_name']);
            return $this->redirectToRoute('adminGalerie');
        }
        $lesGaleries=array_reverse($lesGaleries);
        return $this->render('@ObsessionMain/Admin/adminGaleries.html.twig',array(
            'galeries'=>$lesGaleries,
            'form'=>$form->createView(),
        ));
    }

    /**
     * @Route("/galeriesAdd/{galerie}",name="adminGalerieAjPhotos")
     * @Method({"GET", "POST"})
     */
    public function adminGalerieAjPhotosAction(Request $request,Galerie $galerie){
        $gal=new Galerie();
        $form=$this->createForm('ObsessionMainBundle\Form\GalerieVideType',$gal);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->copiePhotosGalerie($galerie,$_FILES['file']['tmp_name']);
            return $this->redirectToRoute('adminGalerie');
        }
        return $this->render('@ObsessionMain/Admin/adminGaleriesAjPhotos.html.twig',array(
            'galerie'=>$galerie,
            'form'=>$form->createView()
        ));
    }

    private function copieMusique(Galerie $galerie){
        $format=explode(".",$galerie->getMusique()->getClientOriginalName())[1];
        $com=explode(" ",$galerie->getNom());
        $nom='';
        foreach ($com as $comm){
            $nom=$nom.$comm."_";
        }
        $nom=substr($nom, 0, -1);
        $nom=$nom.'.'.$format;
        $url="bundles/obsessionmain/music/";
        $galerie->getMusique()->move($url,$nom);
        $galerie->setMusique($nom);
    }

    /**
     * @Route("/galerieSup/{galerie}",name="supGalerie")
     * @Method({"GET", "POST"})
     */
    public function adminSuppressionGalerieAction(Request $request,Galerie $galerie){


        $urlHD="bundles/obsessionmain/img/photosGalerie/HD/";
        $urlMiniature="bundles/obsessionmain/img/photosGalerie/miniature/";
        $url="bundles/obsessionmain/music/";
        $em=$this->getDoctrine()->getManager();
        unlink($url.$galerie->getMusique());
        foreach ($galerie->getPhotos() as $photo){
            unlink($urlHD.$photo->getChemin());
            unlink($urlMiniature.$photo->getChemin());
            $photo->setGalerie(null);
            $galerie->removePhoto($photo);
            $em->remove($photo);
        }
        $em->remove($galerie);
        $em->flush();
        return $this->redirectToRoute('adminGalerie');

    }

    private function copieAffiche(Affiche $affiche){
        $format=explode(".",$affiche->getChemin()->getClientOriginalName())[1];
        $com=explode(" ",$affiche->getCommentaire());
        $nom='';
        foreach ($com as $comm){
            $nom=$nom.$comm."_";
        }
        $nom=substr($nom, 0, -1);
        $nom=$nom.'.'.$format;

        $urlHD=$this->container->getParameter('affiches_url').'/HD/'.$nom;
        $urlMiniature=$this->container->getParameter('affiches_url').'/miniature/'.$nom;
        $this->get('image.handling')->open($affiche->getChemin()->getPathname())->cropResize(678)->save($urlHD);
        $this->get('image.handling')->open($affiche->getChemin()->getPathname())->cropResize(200)->save($urlMiniature);
        $em=$this->getDoctrine()->getManager();
        $affiche->setChemin($nom);
        $em->persist($affiche);
        $em->flush();
    }

    private function copieCouvertureGalerie(Galerie $galerie){
        $format=explode(".",$galerie->getImage()->getClientOriginalName())[1];
        $com=explode(" ",$galerie->getNom());
        $nom='';
        foreach ($com as $comm){
            $nom=$nom.$comm."_";
        }
        $nom=substr($nom, 0, -1);
        $nom=$nom.'.'.$format;

        $url="bundles/obsessionmain/img/couv-photos/".$nom;
        $this->get('image.handling')->open($galerie->getImage()->getPathname())->cropResize(394)->save($url);
//        $em=$this->getDoctrine()->getManager();
        $galerie->setImage($nom);
//        $em->persist($galerie);
//        $em->flush();
    }

    private function copiePhotosGalerie(Galerie $galerie,$photos){

        $em=$this->getDoctrine()->getManager();
        $urlHD="bundles/obsessionmain/img/photosGalerie/HD/";
        $urlMiniature="bundles/obsessionmain/img/photosGalerie/miniature/";
        $num=$this->getDoctrine()->getManager()->getRepository('ObsessionMainBundle:Photo')->findNumNouvellePhoto();
        foreach ($photos as $photo){
            $this->get('image.handling')->open($photo)->cropResize(1024)->save($urlHD.$num.'.jpg');
            $this->get('image.handling')->open($photo)->cropResize(392)->save($urlMiniature.$num.'.jpg');
            $phot=new Photo();
            $phot->setChemin($num.'.jpg');
            $phot->setGalerie($galerie);
            $galerie->addPhoto($phot);
            $num++;
            $em->persist($phot);
        }
        $em->persist($galerie);
        $em->flush();
    }

    /**
     * @Route("/lieux",name="ajLieux")
     * @Method({"GET", "POST"})
     */
    public function adminAjoutLieuAction(Request $request){
        $lieu=new Lieu();
        $lieux=$this->getDoctrine()->getManager()->getRepository('ObsessionMainBundle:Lieu')->findAllOrder();
        $form=$this->createForm('ObsessionMainBundle\Form\LieuType',$lieu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($lieu);
            $em->flush();

            return $this->redirectToRoute('ajLieux');
        }
        return $this->render('@ObsessionMain/Admin/adminAjoutLieu.html.twig',array(
            'form'=>$form->createView(),
            'lieux'=>$lieux,
        ));
    }

    /**
     * @Route("/lieuxEdit/{lieu}",name="editLieux")
     * @Method({"GET", "POST"})
     */
    public function adminEditLieuAction(Request $request,Lieu $lieu){

        $form=$this->createForm('ObsessionMainBundle\Form\LieuType',$lieu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($lieu);
            $em->flush();

            return $this->redirectToRoute('ajLieux');
        }
        return $this->render('@ObsessionMain/Admin/adminEditLieu.html.twig',array(
            'form'=>$form->createView(),
        ));
    }

    /**
     * @Route("/soireesSup/{soiree}",name="supSoiree")
     * @Method({"GET", "POST"})
     */
    public function adminSuppressionSoireeAction(Request $request,Soiree $soiree){

        $em=$this->getDoctrine()->getManager();
        $em->remove($soiree);
        $em->flush();
        return $this->redirectToRoute('ajSoiree');

    }

    /**
     * @Route("/affichesSup/{affiche}",name="supAffiche")
     * @Method({"GET", "POST"})
     */
    public function adminSuppressionAfficheAction(Request $request,Affiche $affiche){

        $this->suppressionAffiche($affiche);
        $em=$this->getDoctrine()->getManager();
        $em->remove($affiche);
        $em->flush();
        return $this->redirectToRoute('ajAffiche');

    }

    private function suppressionAffiche(Affiche $affiche){
        $urlHD=$this->container->getParameter('affiches_url').'/HD/'.$affiche->getChemin();
        $urlMiniature=$this->container->getParameter('affiches_url').'/miniature/'.$affiche->getChemin();
        unlink($urlHD);
        unlink($urlMiniature);
    }
}
