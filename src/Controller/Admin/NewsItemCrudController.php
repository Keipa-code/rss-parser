<?php

namespace App\Controller\Admin;

use App\Entity\NewsItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Form\Type\JsonType;

class NewsItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return NewsItem::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('link'),
            TextEditorField::new('description'),
            TextField::new('guid'),
            DateField::new('pubDate'),
            TextField::new('author'),
            CollectionField::new('enclosure')
                ->setTemplatePath('newsmedia.html.twig')
                ->onlyOnDetail()
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(CRUD::PAGE_INDEX, 'detail');
    }
}
