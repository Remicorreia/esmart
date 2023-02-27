<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

Class GestionnaireImage 
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }
    public function manageImage($entity, $form, $entityRepository) {
        
        if( $fichier = $form->get("photo")->getData() ){

                // on récupère le nom du fichier 
            $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
            // La classe AsciiSlugger va remplacer les caractères spéciaux par des caractères autorisés dans les URL
            $slugger = new AsciiSlugger();
            $nomFichier = $slugger->slug($nomFichier);
            $nomFichier .= "_" . uniqid();
            $nomFichier .= "." . $fichier->guessExtension();
            // on deplace le fichier dans le dossier public/images avec le nouveau nom de fichier 
            $fichier->move("images", $nomFichier);
    
            if( $entity->getPhoto() ){    
                $fichier = $this->params->get("image_directory") . $entity->getPhoto();
                if( file_exists($fichier) ){
                    unlink($fichier);    
                }
            }
    
            $entity->setPhoto($nomFichier);
            }
            $entityRepository->save($entity, true);
    }
}