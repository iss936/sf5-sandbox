<?php

namespace App\Form;

use App\Entity\Sandbox;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SandboxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                dump('PRE_SUBMIT');

                $data = $event->getData();
                $form = $event->getForm();
                dump($data);
                dump($form);
            })
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                dump('POST_SUBMIT');

                $data = $event->getData();
                $form = $event->getForm();
                dump($data);
                dump($form);
            })
             ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                dump('submit');
                $data = $event->getData();
                $form = $event->getForm();
                dump($data);
                dump($form);
            })

            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                dump('PRE_SET_DATA');
                $data = $event->getData();
                $form = $event->getForm();
                dump($data);
                dump($form);
            })
            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
                dump('POST_SET_DATA');
                $data = $event->getData();
                $form = $event->getForm();
                dump($data);
                dump($form);
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sandbox::class,
        ]);
    }
}
