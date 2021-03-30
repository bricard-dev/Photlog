<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
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
        $id = IdField::new('id');
        $title = TextField::new('title');
        $content = TextEditorField::new('content');
        $isEnable = BooleanField::new('isEnable', 'Enable')->setFormattedValue(1);
        $viewed = IntegerField::new('viewCounter', 'Viewed')->setTextAlign('left');
        $imageName = ImageField::new('imageName', 'Image')->setBasePath('uploads/posts');
        $imageFile = Field::new('imageFile', 'Image')
            ->setFormType(VichImageType::class)
            ->setFormTypeOption('allow_delete', false)
            ->setHelp('Upload your picture in PNG or JPEG format');
        $categories = AssociationField::new('categories')
            ->setTextAlign('left')
            ->setTemplatePath('admin/field/category.html.twig')
            ->setHelp('Assign your post to at least one category');
        $createdAt = DateTimeField::new('createdAt')->renderAsChoice();
        $updatedAt = DateTimeField::new('updatedAt')->renderAsChoice();

        $panelDescription = FormField::addPanel('Description')->setIcon('fas fa-quote-right');
        $panelFile = FormField::addPanel('Picture')->setIcon('far fa-image');
                
        if (Crud::PAGE_INDEX === $pageName) {
            return [$isEnable, $imageName, $title, $content, $createdAt, $categories, $viewed];
        } elseif (Crud::PAGE_NEW === $pageName) {
            $imageFile->setFormTypeOption('required', true);
            return [$panelDescription, $title, $content, $categories, $isEnable, $panelFile, $imageFile];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$panelDescription, $title, $content, $categories, $isEnable, $panelFile, $imageFile];
        } else {
            return [$id, $title, $content, $isEnable, $viewed, $imageName, $imageFile, $categories, $createdAt, $updatedAt];
        }  
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('title')
            ->add('categories')
        ;
    }
}
