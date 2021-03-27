<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('login')
            ->add('mdp',PasswordType::class)
            ->add('image',FileType::class,['attr'=>['accept'=>'.pdf,.png,.jpg','class'=> 'form-control', 'placeholder'=> 'Please attach picture'],'label'=>false])
            ->add('role',ChoiceType::class,['choices'=>['Admin'=>'admin','client'=>'client'],'expanded'=>true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
