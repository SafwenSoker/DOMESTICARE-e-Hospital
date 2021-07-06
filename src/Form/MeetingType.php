<?php

namespace App\Form;

use App\Entity\Meeting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeetingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('uuid')
            ->add('host_id')
            ->add('host_email')
            ->add('topic')
            ->add('status')
            ->add('start_time')
            ->add('duration')
            ->add('created_at')
            ->add('start_url')
            ->add('join_url')
            ->add('password')
            ->add('h323_password')
            ->add('pstn_password')
            ->add('encrypted_password')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Meeting::class,
        ]);
    }
}
