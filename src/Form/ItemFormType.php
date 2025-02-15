<?php

namespace App\Form;

use App\Entity\Item;
use DateTimeImmutable;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pid')
            ->add('sort')
            ->add('uid')
            ->add('name')
            ->add('note')
            ->add('start_date', null, [
                'widget' => 'single_text',
            ])
            ->add('due_date', null, [
                'widget' => 'single_text',
            ])
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
            ->add('type')
            ->add('is_complete');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
