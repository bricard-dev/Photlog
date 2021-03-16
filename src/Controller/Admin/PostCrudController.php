<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\Type\Admin\DateCalendarFilterType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Menu\SectionMenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Post')
            ->setEntityLabelInPlural('Posts')
            ->setSearchFields(['id', 'title'])
            ->setDateTimeFormat('MMM. dd, yyyy')
            ->setPaginatorPageSize(10)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            BooleanField::new('enabled'),
            ImageField::new('imageName', 'Image')
                ->setBasePath('uploads/posts')
                ->hideOnForm(),
            TextareaField::new('imageFile', 'Picture')
                ->setFormType(VichImageType::class)
                ->setFormTypeOption('allow_delete', false)
                ->hideOnIndex(),
            TextField::new('title'),
            TextEditorField::new('content'),
            DateTimeField::new('createdAt')
                ->onlyOnIndex(),
                //->renderAsChoice(),
            //DateTimeField::new('updatedAt')->onlyOnIndex(),
            AssociationField::new('categories')
                ->setTextAlign('left')
                ->setTemplatePath('admin/field/category.html.twig'),
            IntegerField::new('viewCounter', 'Viewed')
                ->onlyOnIndex()
                ->setTextAlign('center'),
                
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('title')
            ->add('categories')
        ;
    }
}
