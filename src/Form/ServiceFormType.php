<?php

namespace App\Form;

use App\Entity\Services;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('slug',null,[
                'required'=>false
            ])
            ->add('content')
            ->add('image',FileType::class,[
                'mapped' => false,
                'required' => false,
                'label'=> 'Featured Image',
                'constraints'=>[
                    new \Symfony\Component\Validator\Constraints\File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ])
                ],
            ])
            ->add('price')
            ->add('gallery',CollectionType::class,[
                'entry_type'=>GalleryFormType::class,
                'mapped' => false,
                'required' => false,
                'allow_add'=>true,
                'allow_delete'=>true,
                'label'=> false,
                'entry_options' => ['label' => false]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Services::class,
        ]);
    }
}
