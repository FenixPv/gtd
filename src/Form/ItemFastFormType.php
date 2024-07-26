<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\User;
use DateTimeImmutable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemFastFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pid', IntegerType::class, [
                'data' => 0,
            ])
            ->add('sort', IntegerType::class, [
                'data' => 0,
            ])
            ->add('uid', IntegerType::class)
            ->add('name')
            ->add('created_at', null, [
                'format'        => DateTimeType::HTML5_FORMAT,
                'view_timezone' => "Europe/Moscow",
                'data'          => new DateTimeImmutable(),
            ])
            ->add('updated_at', null, [
                'format'        => DateTimeType::HTML5_FORMAT,
                'view_timezone' => "Europe/Moscow",
                'data'          => new DateTimeImmutable(),
            ])
            ->add('type', HiddenType::class, [
                'data' => 'task'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
