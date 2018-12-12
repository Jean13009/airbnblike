<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnonceType extends AbstractType {
    
    private function getConfiguration($label, $placeholder) {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
                ]
            ];
        }
        
        public function buildForm(FormBuilderInterface $builder, array $options) {
            $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre", "Tapez le titre de l'annonce"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction", "Décrivez l'annonce"))
            ->add('content', TextareaType::class, $this->getConfiguration("Description", "Description détailléede l'annonce"))
            ->add('coverImage', UrlType::class, $this->getConfiguration("URL de l'image", "Adresse de l'image"))
            ->add('rooms', IntegerType::class, $this->getConfiguration("Nombre de chambre", "Indiquez le nombre de chambre"))
            ->add('price', MoneyType::class, $this->getConfiguration("Prix par nuit", "Indiquez le prix par nuit"))
            ->add('save', SubmitType::class, [
                'label' => 'Créer la nouvelle annonce',
                'attr' => [
                    'class' => 'btn btn-primary'
                    ]
                    ]);
                }
                
                public function configureOptions(OptionsResolver $resolver)
                {
                    $resolver->setDefaults([
                        'data_class' => Ad::class,
                        ]);
                    }
                }
                