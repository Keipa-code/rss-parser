<?php

namespace App\Controller\Admin;

use App\Entity\ParseLog;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ParseLogCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ParseLog::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            DateField::new('date'),
            TextField::new('requestMethod'),
            TextField::new('requestURL'),
            TextField::new('responseHTTPCode'),
            CollectionField::new('responseBody')
                ->onlyOnDetail()
                ->setTemplatePath('logsarray.html.twig'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(CRUD::PAGE_INDEX, 'detail');
    }
}
