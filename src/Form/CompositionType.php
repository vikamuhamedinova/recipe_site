<?php

namespace App\Form;

use App\Entity\Composition;
use App\Entity\Recipe;
use App\Entity\Ingredient;
use App\Entity\Dimension;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompositionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('id_ingredient', EntityType::class,
					array('label' => 'Ингредиент',
						'class' => Ingredient::class
				
			))
			->add('amount', NumberType::class, 
                array('label' => 'Количество',
					'attr' => array('class' =>'form-control')
			))
            ->add('id_dimension', EntityType::class,
					array('label' => 'Единицы меры',
						'class' => Dimension::class
				
			))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Composition::class,
        ]);
    }
}
