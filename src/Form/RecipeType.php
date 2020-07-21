<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name_recipe', TextType::class, 
				array('label' => 'Название блюда',
					'attr' =>array('class' =>'form-control',
					'placeholder'=>'Введите название')
			))
            ->add('portion', IntegerType::class, 
                array('label' => 'Количество порций',
					'attr' => array('class' =>'form-control')
			))
            ->add('time', IntegerType::class, 
                array('label' => 'Время',
					'attr' => array('class' =>'form-control')
			))
            ->add('photoFile', FileType::class, 
				array('label' => 'Фотография',
					'mapped' => false,
					'required' => false,
					'constraints' => [
						new Image([
							'maxSize' => '5M'
						])
					],
					'attr' => array('placeholder' =>'Select an article image')
			))			
            ->add('id_category', EntityType::class,
					array('label' => 'Категория блюда',
						'class' => Category::class
				
			))
			->add('phases', CollectionType::class,
					array('entry_type' => PhaseType::class,
					'entry_options' => ['label' => false],
					'by_reference' => false,
					'allow_add' => true,
					'allow_delete' => true,
			))
			->add('compositions', CollectionType::class,
					array('entry_type' => CompositionType::class,
					'entry_options' => ['label' => false],
					'by_reference' => false,
					'allow_add' => true,
					'allow_delete' => true,
			))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
