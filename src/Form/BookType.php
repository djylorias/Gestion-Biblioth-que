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

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('synopsis')
            ->add('nb_pages')
            ->add('author')
            ->add('is_borrowed', EntityType::class, [
                'class' => Subscriber::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'placeholder' => 'Available',
                'required' => false,
            ])
            ->add('save', SubmitType::class,[
                'attr' => ['class' => 'float-left mr-2']
            ])
            ->add('cancel', ButtonType::class,[
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
