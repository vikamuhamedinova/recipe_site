<?php

namespace App\Form;

use App\Entity\Phase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Image;

class PhaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', IntegerType::class, 
                array('label' => 'Номер этапа',
					'attr' => array('class' =>'form-control')
			))
            ->add('content', TextareaType::class,
				array('label' => 'Содержание',
					'attr' =>array('class' =>'form-control',
				))
			)
			->add('photoPhaseFile', FileType::class, 
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Phase::class,
        ]);
    }
}
