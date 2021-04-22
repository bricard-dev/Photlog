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
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

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
        $firstName = TextField::new('firstName', 'First name');
        $lastName = TextField::new('lastName', 'Last name');
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
        $password = TextField::new('plainPassword', 'Password')
            ->setFormType(RepeatedType::class)
            ->setFormTypeOptions([
                // 'type' => PasswordType::class,
                'required' => 'true',
                'invalid_message' => 'The password fields must match.',
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm password'],
            ]);
        $createdAt = DateTimeField::new('createdAt')->renderAsChoice();
        $updatedAt = DateTimeField::new('updatedAt');

        $panelGeneral = FormField::addPanel('Generals informations')->setIcon('fas fa-user');
        $panelAuthentication = FormField::addPanel('Authentication')->setIcon('fas fa-lock');
        $panelAuthorization = FormField::addPanel('Authorization')->setIcon('fas fa-id-badge');
        $panelOthersInformations = FormField::addPanel('Others informations')->setIcon('fas fa-info-circle');

        if (Crud::PAGE_INDEX === $pageName) {
            return [
                $firstName,
                $lastName,
                $username,
                $email,
                $roles,
                $createdAt
            ];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [
                $panelGeneral,
                $firstName,
                $lastName,
                $username,
                $email,
                $panelAuthentication->setHelp('Minimum 8 characters, at least 1 uppercase letter, 1 lowercase letter 1 one number'),
                $password,
                $panelAuthorization,
                $roles
            ];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [
                $panelGeneral,
                $firstName,
                $lastName,
                $username,
                $email,
                $panelAuthentication->setHelp('Minimum 8 characters, at least 1 uppercase letter, 1 lowercase letter 1 one number'),
                $password->setFormTypeOption('required', false), 
                $panelAuthorization,
                $roles,
                $panelOthersInformations,
                $createdAt
            ];
        } else {
            return [
                $panelGeneral,
                // $id, 
                $username,
                $email,
                $panelAuthorization,
                $roles,
                $panelOthersInformations,
                $createdAt, 
                $updatedAt
            ];
        }  
    }
}
