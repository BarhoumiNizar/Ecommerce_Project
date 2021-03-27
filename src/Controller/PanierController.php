<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Panier;
use App\Repository\UsersRepository;
use App\Repository\ArticlesRepository;
use App\Repository\PanierRepository;
class PanierController extends AbstractController
{
    /**
     * @Route("/Addpanier", name="Addpanier")
     */
    public function PanierAdd(Request $request,UsersRepository $repUser,ArticlesRepository $repArticle): Response
    {
       $qte_demande=$request->get('qte');
       $id_article=$request->get('article');//article c'est le nom de champ de formulaire
       //récupération de session de user connecté
       $session=new session();
       $id_user=$session->get('clients')->getId();// retourne l'id de user connecté
       $user=$repUser->find($id_user);// c'est le user == enregistrement dans la table User d'id = $id_user
       $article=$repArticle->find($id_article);
       $date=date('Y-m-d');
       
       // Pour remplir notre Panier
          $commande= new Panier();// $commande c'est l'objet de type Panier
           $commande->setQte($qte_demande);
           $commande->setDate($date);
           $commande->setPanierUser($user);
           $commande->setArticles($article);
            // connexion avec doctrine
          $connexion=$this->getDoctrine()->getManager();
          $connexion->persist($commande);
          //Exécution
          $connexion->flush();
        return $this->redirectToRoute('Panier');
    }

    /**
     * @Route("/Panier", name="Panier")
     */
    public function panier(PanierRepository $pn){
       // Affichage de Panier
       $session=new session();
       $id_user=$session->get('clients')->getId();// retourne l'id de user connecté
         $paniers=$pn->findBy(array('panier_user'=>$id_user));

       return $this->render('panier/panier.html.twig',['panier'=>$paniers]);


    }


}
