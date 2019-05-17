Simple Google reCAPTCHA FormType and Validator Component for Symfony2 Forms component
================================================

[![License](https://poser.pugx.org/dario_swain/re-captcha-validator/license)](https://packagist.org/packages/ed.sukharev/re-captcha-validator)

Really light and simple reCAPTCHA component for Symfony Forms component (does not require Symfony Framework),
it's not a Bundle, you can reconfigure all components whatever you like.

You can find full documentation about Google reCAPTCHA API v2 [here](http://developers.google.com/recaptcha/intro).

Installation
------------

You can install this package with [Composer](http://getcomposer.org/).
Run following:

``` json
composer require ed.sukharev/re-captcha-validator
```

Usage Example
-------------

Add public and private keys, and configure reCAPTCHA Form Type like a service. After this you can add reCAPTCHA type to 
your form:

``` php
<?php

namespace AcmeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('message', 'textarea')
            /** In type add your form alias **/
			->add('captcha', 'ds_re_captcha', array('mapped' => false))
			->add('send', 'submit');
    }

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
		    /** This option is require, because reCaptcha api.js add extra field "g-recaptcha-response" to form **/
			'allow_extra_fields' => true,
		));
	}
}

```

Next step, you need to render the widget onto your view. Follows the example for Twig template engine, but it should be similar to others.

Either inline it in your form:
```twig
{% extends 'AcmeBundle::layout.html.twig' %}

{% form_theme form _self %}

{% block ds_re_captcha_widget %}
    {% spaceless %}
        <div class="g-recaptcha" data-sitekey="{{ public_key }}"></div>
        <script src="{{ js_api_url }}?hl={{ lang }}" async defer></script>
    {% endspaceless %}
{% endblock ds_re_captcha_widget %}

{% block content %}
    {{ form(your_form) }}
{% endblock %}

```

or ship it as separate file (e.g. `ds_recaptcha_field.html.twig`)

```twig
{% block ds_re_captcha_widget %}
    {% spaceless %}
        <div class="g-recaptcha" data-sitekey="{{ public_key }}"></div>
        <script src="{{ js_api_url }}?hl={{ lang }}" async defer></script>
    {% endspaceless %}
{% endblock ds_re_captcha_widget %}
```

and include it in your twig:

```twig
{% extends 'AcmeBundle::layout.html.twig' %}

{% form_theme form 'ds_recaptcha_field.html.twig' %}

{% block content %}
    {{ form(your_form) }}
{% endblock %}
```

Copyright
---------

Copyright (c) 2019 Eduard Sukharev <sukharev.eh@gmail.com>.
Copyright (c) 2015 Ilya Pokamestov <dario_swain@yahoo.com>.
