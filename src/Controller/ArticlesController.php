<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ArticlesFormType;
use App\Entity\Articles;
use App\Repository\ArticlesRepository;
class ArticlesController extends AbstractController
{
 // Route("/articles==>URL", name="articles==>redirection et dans le href href")   
    /**
     * @Route("/articles", name="articles")
     */
    public function index(Request $req): Response
    {
        $art=new Articles();
       $form=$this->createForm(ArticlesFormType::class,$art);
       $form->handleRequest($req);// $req c'est le formulaire $form(ArticlesFormType)
       if($form->isSubmitted())// clic sur bouton submit
       {
        // si on a le cas de persist(ajout, update) ou remove on va faire la connexion avec doctrine
        // Doctrine c'est ORM(Objet Relation Mapping=== BD en Symfony)
         $cnx=$this->getDoctrine()->getManager();// connexion avec Doctrine
        // Persist==Ajout
        $cnx->persist($art);//prepare() en PDO
        //Exécution
        $cnx->flush();//execut() en PDO
         return $this->redirectToRoute('articles');

       }
       return $this->render('articles/index.html.twig', [
            'controller_name' => 'ArticlesController',
             'form'=>$form->createView()

        ]);
    }
     /**
      * @Route("/Affiche",name="AfficherArticles")
      */

    public function getArticles(ArticlesRepository $repArticle)
    {
        $res=$repArticle->findAll();// select * from Articles

        return $this->render('articles/affiche.html.twig',['res'=>$res]);
    }

    /**
      * @Route("/delete/{id}",name="deleteArticle")
      */

      public function deleteArticle(ArticlesRepository $repArticle,$id)
      {
          $res=$repArticle->find($id);// select * from Articles where id='$id'
          $cnx=$this->getDoctrine()->getManager();// connexion avec Doctrine
          $cnx->remove($res);// suppression de $res
          $cnx->flush();
          // Redirection en Symfony // AfficherArticles c'est le nom de route
          return $this->redirectToRoute('AfficherArticles');
      }
     /**
      * @Route("/update/{id}",name="UpdateArticle")
      */
      public function ModifierArticle(ArticlesRepository $repArticle,$id,Request $req)
      {
          $repArticle=$repArticle->find($id);// dans le cas d'afficher un formulaire de modification 
         $form=$this->createForm(ArticlesFormType::class,$repArticle);
          $form->handleRequest($req);// c'est obligatoir dans le form generé
         if($form->isSubmitted())
         {
          // connexion avec Doctrine
          $cnx=$this->getDoctrine()->getManager();
          $cnx->persist($repArticle);// c'est le res de find($id)
          $cnx->flush();
          //redirection vers la page d'affichage
          return $this->redirectToRoute('AfficherArticles');

         }
        return  $this->render("articles/modifier.html.twig",['form'=>$form->createView()]);
      }
     /**
      * @Route("/Recherche",name="Recherche")
      */
   public function recherche(Request $req,ArticlesRepository $repArticle)
   {
   
     $resRecheche=null;$nbs=0;$cat=null;
      if($req->get('ok')!=null)// si on clic sur le bouton
      {
        $cat=$req->get('categorie');// la valeur saisie dans le champ categorie
        // Requet Doctrine pour la recherche
         $resRecheche=$repArticle->findBy(['categorie'=>$cat]);//Dql
         // select * from articles where categorie=$cat 
         $nbs=count($resRecheche);// count() fonction en php pour calculer le nombre des enregistrements d'une resultat de selection ===> le resultat de count de type int
      }
      
    return $this->render("articles/recherche.html.twig",['res'=>$resRecheche,
    'nbArticle'=>$nbs,'cat'=>$cat,'frm'=>$form->createView()]);
   }

// Fonction Recherche avec formulaire génére "ArticleFormType"
/**
      * @Route("/RechercheFormG",name="RechercheFormG")
      */ 
      public function RechercheFormG(Request $req,ArticlesRepository $repArticle){
         $form=$this->createForm(ArticlesFormType::class);
         // si l'appel de formulaire sans liaison donc Pas de handleRequest
         // non on a pas le handleRequest
         $resRecheche=null;
         if($req->get('valider'))// c'est le clic sur le bouton de type submit de name= valider
         {
           // Récupérer le champ de formulaire
           $forms=$req->get('articles_form');// articles_form de type array []
           //var_dump($forms);
           $categorie=$forms['categorie'];
           //echo '<h1>'.$categorie.'</h1>';   
           // Requet Doctrine pour la recherche
         $resRecheche=$repArticle->findBy(['categorie'=>$categorie]);//Dql
         // select * from articles where categorie=$cat 
         $nbs=count($resRecheche);// count() fonction en php pour calculer le nombre des enregistrements d'une resultat de selection ===> le resultat de count de type int
        }
        return $this->render("articles/RechercheFormG.html.twig",
        ['frm'=>$form->createView(),'res'=>$resRecheche]);
      }
     
}
 
