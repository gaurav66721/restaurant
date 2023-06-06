<?php

namespace App\Form;

use App\Entity\MenuItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuItemFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',null,[
                'label' => 'Menu Item Name',
                'attr' => [
                    'placeholder' => 'Enter menu item name',
                ],
            ])
            ->add('recipes')
            ->add('price1')
            ->add('price2')
            ->add('status')
            ->add('menu','Symfony\Bridge\Doctrine\Form\Type\EntityType',[
                'class' => 'App\Entity\Menu',
                'choice_label' => 'name',
                'placeholder' => 'Select a menu',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MenuItem::class,
        ]);
    }
}
