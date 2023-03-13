<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Detail;
use App\Entity\Smartphone;
use App\Repository\SmartphoneRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/panier')]
class PanierController extends AbstractController
{
    #[Route('/', name: 'app_panier')]
    public function index(Session $session): Response
    {
        $panier = $session->get("panier", []);
        // var_dump($panier);die;
        return $this->render('panier/index.html.twig', [
            'panier' => $panier,
          
        ]);
    }

#[Route('/ajouter-smartphone-{id}', name: 'app_panier_ajouter' , requirements:["id"=>"\d+"])]
public function ajouter($id, SmartphoneRepository $pr, Session $session, Request $rq)
{

    $quantite = $rq->query->get("qte", 1) ?: 1;
    $smartphone = $pr->find($id);
    $panier = $session->get("panier", []); // on récupère ce qu'il y a dans le panier en session

    $smartphoneDejaDansPanier = false;
    foreach ($panier as $indice => $ligne) {
        if ($smartphone->getId() == $ligne["smartphone"]->getId()) {
            $panier[$indice]["quantite"] += $quantite;
            $smartphoneDejaDansPanier = true;
            break;  // pour sortir de la boucle foreach
        }
    }
    if (!$smartphoneDejaDansPanier) {
        $panier[] = ["quantite" => $quantite, "smartphone" => $smartphone];  // on ajoute une ligne au panier => $panier est un array d'array
    }


    $session->set("panier", $panier);  // je remets $panier dans la session, à l'indice 'panier'
    //dd($smartphone); // dd : Dump and Die
    

    //return $this->redirectToRoute("app_home");
    $nb = 0;
    foreach ($panier as $ligne){
        $nb += $ligne["quantite"];
    }


    return $this->json($nb);
}
#[Route('/vider', name: 'app_panier_vider')]

public function vider(Session $session)
{
    $session->remove("panier");
    return $this->redirectToRoute("app_panier");
}

#[Route('/supprimer-smartphone-{id}', name: 'app_panier_supprimer',requirements:["id"=>"\d+"])]
public function supprimer(Smartphone $smartphone, Session $session)
{
    $panier = $session->get("panier", []);
        foreach ($panier as $indice => $ligne) {
            if ($ligne['smartphone']->getId() == $smartphone->getId()) {
                unset($panier[$indice]);
                break;
            }
        }
        $session->set("panier", $panier);
        return $this->redirectToRoute("app_panier");
}
#[Route('/valider', name: 'app_panier_valider')]
#[IsGranted('ROLE_CLIENT')]
public function valider(Session $session, SmartphoneRepository $smartphoneRepository, EntityManagerInterface $em)
{
    $panier = $session->get("panier", []);
    if ($panier) {
        $cmd = new Commande;
        $cmd->setDateEnregistrement(new DateTime());
        $cmd->setUser($this->getUser()); // affecte l'utilisateur connecté a la propriété 'client' de l'objet $cmd
        $montant = 0;
        foreach ($panier as $ligne) {
            /*  On recupere le smartphone en BDD plutot que d'utiliser l'objet smartphone enregistré en session, sinon il y a un bug
                (lié a la serialisation en session) qui ajoute un doublon dans la table smartphone
            */
            $smartphone = $smartphoneRepository->find($ligne["smartphone"]->getId());
            $montant += $smartphone->getPrix() * $ligne["quantite"];

            $detail = new Detail;
            $detail->setPrix($smartphone->getPrix());
            $detail->setQuantite($ligne["quantite"]);
            $detail->setSmartphone($smartphone);
            $detail->setCommande($cmd);
            $em->persist($detail); // 'persist' est l'equivalant d'une requete préparée INSERT INTO. La requete est mise en attente.

            $smartphone->setStock($smartphone->getStock() - $ligne["quantite"]);
        }
        $cmd->setMontant($montant);
        $em->persist($cmd);
        $em->flush(); // Toutes les requetes en attente sont executées
        $session->remove("panier");
        $this->addFlash("success", "Votre commande a été enregistrée");
        return $this->redirectToRoute("app_panier");
    }
    $this->addFlash("danger", "Le panier est vide. Vous ne pouvez pas valider la commande.");
    return $this->redirectToRoute("app_panier");
}

 /**
     * @Route("/ajouter-smartphone-card-{id}", name="app_panier_ajouter_card", requirements={"id"="\d+"})
     */
public function ajouterCard($id, SmartphoneRepository $pr, Session $session, Request $rq)
{        
    $quantite = $rq->query->get("qte");        
    $nouveauPrixTotal = $rq->query->get("nouveauPrixTotal");        
    $smartphone = $pr->find($id);
    $panier = $session->get("panier", []);
    $nb = 0;
    $prixTotal = 0;

    foreach ($panier as $indice => $ligne) {
        if ($smartphone->getId() == $ligne["smartphone"]->getId()) {
            $panier[$indice]["quantite"] += $quantite;
            $nb = $panier[$indice]["quantite"];
            
            // break;  // pour sortir de la boucle foreach
        }
        $prixTotal += $panier[$indice]["quantite"] * $ligne["smartphone"]->getPrix();
    }
        // dd($prixTotal);
    $session->set("panier", $panier);       
    return $this->json($nb . "/". $smartphone->getPrix() . "/" . $prixTotal);
}


}
