<?php

namespace App\Controller;

use App\Entity\Smartphone;
use App\Form\SmartphoneType;
use App\Repository\SmartphoneRepository;
use App\Service\GestionnaireImage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/smartphone')]
class SmartphoneController extends AbstractController
{
    #[Route('/', name: 'app_smartphone_index', methods: ['GET'])]
    public function index(SmartphoneRepository $smartphoneRepository): Response
    {
        return $this->render('smartphone/index.html.twig', [
            'smartphones' => $smartphoneRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_smartphone_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SmartphoneRepository $smartphoneRepository, GestionnaireImage $gestionImage): Response
    {
        $smartphone = new Smartphone();

        // La methode createForm: Crée et renvoie une instance de formulaire à partir du type du formulaire (ici ProduitType)
        //Cette methode (createForm) prend trois parametres :(string $type, $data = null, array $options = []) dont le premier parametre est un parametres obligatoire de type string qui definit la classType qui creera un formulaire.
        //le deuxieme parametre est optionnel et est de type mixed (accpte tout type de caracteres) dans notre cas la valeur du deuxieme parametre est un objet de l'entity Produit et enfin le troisieme parametre lui est optionnel egalement et est de type array, mais le troisieme parametre n'est pas utilisé dans notre cas
        // @param string $type
        // @param mixed $data
        // @param array $options
        // @return \Symfony\Component\Form\FormInterface

        //on declare une variable de type objet 'FormInterface'
        $form = $this->createForm(SmartphoneType::class, $smartphone);

        
        //Inspecte la requête donnée et appelle {@link submit()} si le formulaire a été soumis.
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gestionImage->manageImage($smartphone, $form, $smartphoneRepository);        
            $smartphoneRepository->save($smartphone, true);

            return $this->redirectToRoute('app_smartphone_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('smartphone/new.html.twig', [
            'smartphone' => $smartphone,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_smartphone_show', methods: ['GET'])]
    public function show(Smartphone $smartphone): Response
    {
        return $this->render('smartphone/show.html.twig', [
            'smartphone' => $smartphone,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_smartphone_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Smartphone $smartphone, SmartphoneRepository $smartphoneRepository): Response
    {
        $form = $this->createForm(SmartphoneType::class, $smartphone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $smartphoneRepository->save($smartphone, true);

            return $this->redirectToRoute('app_smartphone_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('smartphone/edit.html.twig', [
            'smartphone' => $smartphone,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_smartphone_delete', methods: ['POST'])]
    public function delete(Request $request, Smartphone $smartphone, SmartphoneRepository $smartphoneRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$smartphone->getId(), $request->request->get('_token'))) {
            $smartphoneRepository->remove($smartphone, true);
        }

        return $this->redirectToRoute('app_smartphone_index', [], Response::HTTP_SEE_OTHER);
    }
}
