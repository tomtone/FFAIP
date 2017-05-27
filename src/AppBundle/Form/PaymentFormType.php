<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 25.05.2017
 * Time: 19:55
 */

namespace AppBundle\Form;


use AppBundle\Http\RequestFactory;
use GuzzleHttp\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ShippingFormType
 * @package AppBundle\Form
 */
class PaymentFormType extends AbstractType
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
            ->add('submit', SubmitType::class, ['label' => 'text_submit_payment_form']);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'payment';
    }

    private function getMetaData(RequestFactory $requestFactory, FormBuilderInterface $builder)
    {
        $client = new Client();
        $request = $requestFactory->getPaymentInformationRequest();
        $data = $client->send($request);
        $data = \GuzzleHttp\json_decode($data->getBody()->getContents(), true);
        $paymentMethods = $data['payment_methods'];
        $choices = [];
        foreach ($paymentMethods as $paymentMethod){
            $choices[$paymentMethod['title']] = $paymentMethod['code'];
        }
        $builder->add('payment', ChoiceType::class, [
            'choices' => $choices,
            'choices_as_values' => true,
            'multiple'=>false,
            'expanded'=>true
        ]);
        return $builder;
    }
}