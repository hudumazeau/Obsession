<?php
/**
 * Created by PhpStorm.
 * User: hudumazeau
 * Date: 26/05/16
 * Time: 19:09
 */

namespace ObsessionMainBundle\Business;


use Doctrine\Common\Persistence\ObjectManager;

final class Utils
{
    public static function getFourMois(ObjectManager $em){
        $jour=new \DateTime();
        $moisId=intval($jour->format('m'));
        $mois=array();
        for ($i=$moisId;$i<($moisId+4);$i++){
            $mois[]=$em->getRepository('ObsessionMainBundle:Mois')->findOneBy(array('id'=>$i));
        }
        return $mois;
    }

    public static function getAnnees(ObjectManager $em){

        $annees=array();
        $soirees=$em->getRepository('ObsessionMainBundle:Soiree')->findAll();
        foreach ($soirees as $soiree){
            $annee=$soiree->getDate()->format('Y');
            if(!in_array($annee,$annees))
                $annees[]=$annee;
        }
        return $annees;
    }

    public static function getMoisAnnee(ObjectManager $em,$annee){

        $mois=array();
        $soirees=$em->getRepository('ObsessionMainBundle:Soiree')->findByAnnee($annee);
        foreach ($soirees as $soiree){
            $moi=$soiree->getDate()->format('m');
            if(!in_array($moi,$mois))
                $mois[]=intval($moi);
        }
        return $mois;
    }
}