<?php

namespace App\Form;

use App\Entity\Pages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('slug',null,['required'=>false])
            ->add('Image',"Symfony\Component\Form\Extension\Core\Type\FileType",[
                'mapped'=>false,
                'required'=>false,
                "label"=>"Featured Image",
                "attr"=>[
                    "class"=>"form-control"
                ],
                "constraints"=>[
                    new \Symfony\Component\Validator\Constraints\File([
                        "maxSize"=>"1024k",
                        "mimeTypes"=>[
                            "image/png",
                            "image/jpeg",
                            "image/jpg"
                        ],
                        "mimeTypesMessage"=>"Please upload a valid Image File"
                    ])
                ]
            ])
            ->add('status')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pages::class,
        ]);
    }
}
