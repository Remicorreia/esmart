<?php

namespace App\Controller\Admin;

use App\Entity\Capacite;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CapaciteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Capacite::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
