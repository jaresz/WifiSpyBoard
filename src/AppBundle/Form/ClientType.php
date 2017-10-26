<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ClientType extends AbstractType
{

    /**
     *
     * {@inheritdoc}
     *
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('mac')
            ->add('ip')
            ->add('selfName')
            ->add('givenName');
        $choices = [];
        for ($in = 0; $in < 29; $in ++) {
            $cssClassName = 'client' . $in;
            $choices[$cssClassName] = $cssClassName;
        }
        $builder->add('cssClass', ChoiceType::class, array(
            'choices' => $choices,
            'expanded' => true,
            'multiple' => false,
            'choice_attr' => function ($category, $key, $index) {
                return [
                    'class' => strtolower($category)
                ];
            }
        )
        );
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Client'
        ));
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getBlockPrefix()
    {
        return 'appbundle_client';
    }
}
