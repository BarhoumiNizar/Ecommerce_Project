<?php

namespace App\Form;

use App\Entity\Articles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class ArticlesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,['label'=>'Saisir un nom','attr'=>['readOnly'=>true,'value'=>'Test']])
            ->add('description')
            ->add('prix')
            ->add('date',DateType::class,['widget'=>'single_text'])
            ->add('qte',IntegerType::class,['attr'=>['min'=>3,'max'=>12,'placeholder'=>'Quantité'],'label'=>'Quantité'])
            ->add('categorie',ChoiceType::class,['label'=>false,'choices'=>['Choisir categorie'=>'Choisir categorie','OPT1'=>'OPTION1','OPT2'=>'OPTION2'],'attr'=>['placeholder'=>'Categorie']])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
