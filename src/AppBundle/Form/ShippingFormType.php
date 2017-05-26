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
use GuzzleHttp\Psr7\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ShippingFormType
 * @package AppBundle\Form
 */
class ShippingFormType extends AbstractType
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
            ->add('submit', SubmitType::class, ['label' => 'text_register']);
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
        $adminTokenRequest = $requestFactory->getAdminTokenRequest();
        $token = $client->send($adminTokenRequest);
        $token = \GuzzleHttp\json_decode($token->getBody()->getContents(), true);

        $request = $requestFactory->getAddressMetadataRequest($token);
        $response = $client->send($request);

        $data = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        foreach ($data as $field){
            dump($field);
            if($field['frontend_input'] == 'text' && $field['visible']) {
                $builder->add($field['attribute_code'], TextType::class, ['label' => $field['store_label']]);
            }elseif($field['frontend_input'] == 'text' && !$field['visible']){
                $builder->add($field['attribute_code'], HiddenType::class, ['label' => $field['store_label']]);
            }elseif($field['frontend_input'] == 'select'){
                $builder->add($field['attribute_code'], ChoiceType::class, [
                    'label' => $field['store_label'],
                    'choices' => $this->prepareChoices($field['options'])
                ]);
            }
        }
        
        return $builder;
    }

    private function prepareChoices($options)
    {
        $choices = [];
        foreach ($options as $option){
            $choices[$option['label']] = $option['value'];
        }
        return $choices;
    }
}