<?php

namespace App\Controller\Admin;

use App\Entity\Smartphone;
use App\Service\GestionnaireImage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SmartphoneCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Smartphone::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ImageField::new('photo')
            ->setBasePath('/images')
            ->setUploadDir('public/images')->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            TextField::new('nom'),
            TextField::new('description'),
            AssociationField::new('capacite'),
            TextField::new('autonomie'),
            TextField::new('annee'),
            TextField::new('pouces'),
            NumberField::new('prix'),

            

        ];
    }
}
