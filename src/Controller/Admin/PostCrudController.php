<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
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
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('title')
            ->add('category')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $title = TextField::new('title');
        $slug = TextField::new('slug')
            ->setHelp('Adress of your post page')
            ->formatValue(function($value) {
                return "/{$value}";
            });
        $content = TextareaField::new('content');
        $isEnable = BooleanField::new('isEnable', 'Enable')->setFormattedValue(1);
        $viewed = IntegerField::new('viewCounter', 'Viewed')->setTextAlign('left');
        $imageName = ImageField::new('imageName', 'Image')->setBasePath('uploads/posts');
        $imageFile = Field::new('imageFile', 'Image')
            ->setFormType(VichImageType::class)
            ->setFormTypeOption('allow_delete', false)
            ->setHelp('Upload your picture in PNG or JPEG format');
        $category = AssociationField::new('category');
        $createdAt = DateTimeField::new('createdAt')->renderAsChoice();
        $updatedAt = DateTimeField::new('updatedAt')->renderAsChoice();
        $comments = AssociationField::new('comments')
            ->setTextAlign('left');

        $panelDescription = FormField::addPanel('Description')->setIcon('fas fa-quote-right');
        $panelFile = FormField::addPanel('Picture')->setIcon('far fa-image');
                
        if (Crud::PAGE_INDEX === $pageName) {
            return [
                $isEnable, 
                $imageName, 
                $title,
                $content,
                $category, 
                $comments, 
                $viewed, 
                $createdAt,
            ];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [
                $panelDescription,
                $title, 
                $content, 
                $category->setHelp('Assign your post to a category'), 
                $isEnable, 
                $panelFile, 
                $imageFile->setFormTypeOption('required', true),
            ];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [
                $panelDescription, 
                $title, 
                $content, 
                $category->setHelp('Assign your post to a category'), 
                $isEnable,
                $createdAt,
                $panelFile, 
                $imageFile,
            ];
        } else {
            return [
                $panelDescription, 
                // $id, 
                $title, 
                $slug,
                $content, 
                $isEnable, 
                $viewed, 
                $category, 
                $createdAt, 
                $updatedAt,
                $panelFile,
                $imageName, 
            ];
        }  
    }
}
