<?php

namespace ObsessionMainBundle\Controller;

use ObsessionMainBundle\Business\Utils;
use ObsessionMainBundle\Entity\Affiche;
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

    private function copieAffiche(Affiche $affiche){
        $urlHD=$this->container->getParameter('affiches_url').'/HD/'.$affiche->getChemin()->getClientOriginalName();
        $urlMiniature=$this->container->getParameter('affiches_url').'/miniature/'.$affiche->getChemin()->getClientOriginalName();
        $urlHDSrc=$this->container->getParameter('affiches_url_src').'/HD/'.$affiche->getChemin()->getClientOriginalName();
        $urlMiniatureSrc=$this->container->getParameter('affiches_url_src').'/miniature/'.$affiche->getChemin()->getClientOriginalName();
        $this->get('image.handling')->open($affiche->getChemin()->getPathname())->cropResize(678)->save($urlHD);
        $this->get('image.handling')->open($affiche->getChemin()->getPathname())->cropResize(678)->save($urlHDSrc);
        $this->get('image.handling')->open($affiche->getChemin()->getPathname())->cropResize(200)->save($urlMiniature);
        $this->get('image.handling')->open($affiche->getChemin()->getPathname())->cropResize(200)->save($urlMiniatureSrc);
        $em=$this->getDoctrine()->getManager();
        $affiche->setChemin($affiche->getChemin()->getClientOriginalName());
        $em->persist($affiche);
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
        $urlHDSrc=$this->container->getParameter('affiches_url_src').'/HD/'.$affiche->getChemin()->getClientOriginalName();
        $urlMiniatureSrc=$this->container->getParameter('affiches_url_src').'/miniature/'.$affiche->getChemin()->getClientOriginalName();
        unlink($urlHD);
        unlink($urlMiniature);
        unlink($urlHDSrc);
        unlink($urlMiniatureSrc);
    }
}
