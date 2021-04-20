<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Form\RoleType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('User')
            ->setEntityLabelInPlural('Users')
            ->setSearchFields(['username', 'email'])
            ->setDateTimeFormat('MM/dd/Y hh:mm a')
            ->setPaginatorPageSize(10)
            ->setDefaultSort(['updatedAt' => 'DESC'])
            ->setEntityPermission('ROLE_ADMIN')
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
            ->add('username')
            ->add('email')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        
        $id = IdField::new('id');
        $username = TextField::new('username');
        $email = EmailField::new('email');
        $roles = ChoiceField::new('roles', 'Role')
            ->allowMultipleChoices(false)
            ->renderExpanded(true)
            ->setFormType(RoleType::class)
            ->setChoices([
                'Administrator' => 'ROLE_ADMIN',
                'Editor' => 'ROLE_EDITOR',
            ]);
        $password = TextField::new('password');
            // ->setFormType(PasswordType::class);
        $createdAt = DateTimeField::new('createdAt')->renderAsChoice();
        $updatedAt = DateTimeField::new('updatedAt');

        if (Crud::PAGE_INDEX === $pageName) {
            return [
                $username,
                $email,
                $roles,
                $createdAt
            ];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [
                $username,
                $email,
                $password,
                $roles
            ];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [
                $username,
                $email,
                $password,
                // $password->setFormTypeOption('required', false), 
                $roles,
                $createdAt
            ];
        } else {
            return [
                // $id, 
                $username,
                $email,
                $roles,
                $createdAt, 
                $updatedAt
            ];
        }  
    }
}
