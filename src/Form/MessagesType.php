<?php

namespace App\Form;

use App\Entity\Patient;
use App\Entity\Messages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MessagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                ["attr" => ["class" => "form-control"]]
            )
            ->add(
                'message',
                TextType::class,
                ["attr" => ["class" => "form-control"]]
            )
            ->add('recipient', EntityType::class, [
                "class" => Patient::class,
                "attr" => ["class" => "form-control"]
            ])
            ->add("envoyer", SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
        ]);
    }
}
