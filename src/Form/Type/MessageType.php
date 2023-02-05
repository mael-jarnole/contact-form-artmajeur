<?php

namespace App\Form\Type;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                "required" => true,
                "label" => "Votre nom :",
                "attr" => ["placeholder" => "Nom / Prénom"],
            ])
            ->add('email', EmailType::class, [
                "required" => true,
                "label" => "Votre email :",
                "attr" => ["placeholder" => "john.doe@mail.com"],
            ])
            ->add('content', TextareaType::class, [
                "required" => true,
                "label" => "Votre message :",
                "attr" => [
                    "placeholder" => "Questions, requête, candidature etc.",
                    "rows" => "10"
                ]
            ])
            ->add('submitMessage', SubmitType::class, ["label" => "Envoyer"]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}