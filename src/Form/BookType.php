<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Subscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Validator\Constraints\Length;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => 'Titre',
            ])
            ->add('synopsis', null, [
                'label' => 'Synopsis',
            ])
            ->add('nb_pages', null, [
                'label' => 'Nombre de pages',
            ])
            ->add('author', null, [
                'label' => 'Auteur.e',
                'constraints' => new Length(['min' => 2, 'max' => 255]),
            ])
            ->add('is_borrowed', EntityType::class, [
                'label' => 'Emprunté par',
                'class' => Subscriber::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'placeholder' => 'Disponible',
                'required' => false,
            ])
            ->add('Sauvegarder', SubmitType::class,[
                'attr' => ['class' => 'float-left mr-2']
            ])
            ->add('Annuler', ButtonType::class,[
                'attr' => [
                    'class' => 'border bg-white text-black! hover:bg-black! hover:text-white!',
                    'onclick' => 'window.history.back()'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
