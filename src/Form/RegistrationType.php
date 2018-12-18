<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends ApplicationType
{
    
       
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder
            ->add('firstName', TextType::class, $this->getConfiguration("Prénom", "Votre Prénom"))
            ->add('lastName', TextType::class, $this->getConfiguration("Nom", "Votre Nom"))
            ->add('email', EmailType::class, $this->getConfiguration("Email", "Votre Email"))
            ->add('picture', UrlType::class, $this->getConfiguration("Photo", "Url de votre avatar"))
            ->add('hash', PasswordType::class, $this->getConfiguration("Password", "Password"))
            ->add('passwordConfirm', PasswordType::class, $this->getConfiguration("Confirmation de mot de passe", "Confirmez le mot de passe"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction", "Présentez vous"))
            ->add('description', TextareaType::class, $this->getConfiguration("Description détaillée", "Détail de votre description"))
            ;
        }
        
        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults([
                'data_class' => User::class,
                ]);
            }
        }
        