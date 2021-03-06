<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
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
            ->setSearchFields(['title'])
            ->setDateTimeFormat('MM/dd/Y hh:mm a')
            ->setPaginatorPageSize(10)
            ->setDefaultSort(['updatedAt' => 'DESC'])
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Action::DETAIL, 'detail')
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_DETAIL, Action::DETAIL)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        
        $id = IdField::new('id');
        $name = TextField::new('name');
        $slug = TextField::new('slug')
            ->setHelp('Adress of your category page')
            ->formatValue(function ($value) {
                return "/{$value}";
            });
        $posts = AssociationField::new('posts')->setTextAlign('left');
        $createdAt = DateTimeField::new('createdAt')->renderAsChoice();
        $updatedAt = DateTimeField::new('updatedAt');

        if (Crud::PAGE_INDEX === $pageName) {
            return [
                $id,
                $name, 
                $slug,
                $posts, 
                $createdAt
            ];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [
                $name
            ];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [
                $name,
                $slug, 
                $createdAt
            ];
        } else {
            return [
                $id, 
                $name, 
                $slug, 
                $posts->setHelp('Posts associated with this category'), 
                $createdAt, 
                $updatedAt
            ];
        }  
    }
}
