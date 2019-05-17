<?php
/*
* This file is part of the ReCaptcha Validator Component.
*
* (c) Ilya Pokamestov
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace DS\Component\ReCaptchaValidator\Form;

use DS\Component\ReCaptchaValidator\Validator\ReCaptchaConstraint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\InvalidConfigurationException;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form type for reCaptcha.
 *
 * @author Ilya Pokamestov <dario_swain@yahoo.com>
 */
class ReCaptchaType extends AbstractType
{
    const JS_API_URL = 'https://www.google.com/recaptcha/api.js';

    /** @var  string */
    protected $publicKey;
    /** @var  string */
    protected $locale;

    public function __construct($publicKey, $locale = null)
    {
        if (null === $publicKey) {
            throw new InvalidConfigurationException('The parameters "public_key" must be configured.');
        }

        $this->publicKey = $publicKey;

        if (null !== $locale) {
            $this->locale = $locale;
        } else {
            $this->locale = 'en';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'public_key' => $this->publicKey,
            'lang' => $this->locale,
            'js_api_url' => self::JS_API_URL
        ));
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated Remove when dropping support for Symfony 2.6 and earlier
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'constraints' => array(new ReCaptchaConstraint())
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ds_re_captcha';
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated Remove when dropping support for Symfony 2.7 and earlier
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
