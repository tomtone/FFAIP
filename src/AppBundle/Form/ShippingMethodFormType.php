<?php
namespace AppBundle\Form;


use AppBundle\Http\RequestFactory;
use GuzzleHttp\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ShippingFormType
 * @package AppBundle\Form
 */
class ShippingMethodFormType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('requestFactory');
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var RequestFactory $requestFactory */
        $requestFactory = $options['requestFactory'];
        $builder = $this->getMetaData($requestFactory, $builder);
        $builder
            ->add('submit', SubmitType::class, ['label' => 'text_submit_shipping_form']);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'shipping';
    }

    private function getMetaData(RequestFactory $requestFactory, FormBuilderInterface $builder)
    {
        $client = new Client();
        $request = $requestFactory->getShippingMethodsRequest();;
        $response = $client->send($request);

        $data = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        $choices = [];
        foreach ($data as $carrier){
            $choices[$carrier['carrier_title']] = $carrier['carrier_code'];
        }
        $builder->add('carrier', ChoiceType::class, [
            'choices' => $choices,
            'choices_as_values' => true,
            'multiple'=>false,
            'expanded'=>true
        ]);
        return $builder;
    }

}