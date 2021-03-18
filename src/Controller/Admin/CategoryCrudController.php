<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Category')
            ->setEntityLabelInPlural('Categories')
            ->setSearchFields(['id', 'name'])
            ->setDateTimeFormat('MMM. dd, yyyy')
            ->setPaginatorPageSize(10)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        
        $id = IdField::new('id');
        $name = TextField::new('name');
        $slug = TextField::new('slug');
        $posts = AssociationField::new('posts')->setTextAlign('left');
        $createdAt = DateTimeField::new('createdAt')->renderAsChoice();
        $updatedAt = DateTimeField::new('updatedAt');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$name, $posts, $createdAt];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $createdAt];
        } else {
            return [$id, $name, $slug, $posts, $createdAt, $updatedAt];
        }  
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
        ;
    }
}
