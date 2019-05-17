<?php
/*
* This file is part of the ReCaptcha Validator Component.
*
* (c) Ilya Pokamestov
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace DS\Component\ReCaptchaValidator\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

class ReCaptchaValidator extends ConstraintValidator
{
    const RECAPTCHA_URL = 'https://www.google.com/recaptcha/api/siteverify';
    /** @var  string */
    protected $privateKey;
    /** @var bool */
    protected $enabled;

    /**
     * @param string $privateKey
     * @param bool $enabled
     */
    public function __construct($privateKey, $enabled = true)
    {
        $this->privateKey = $privateKey;
        $this->enabled = $enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!($constraint instanceof ReCaptchaConstraint)) {
            throw new InvalidArgumentException('Use ReCaptchaConstraint for ReCaptchaValidator.');
        }

        if (false === $this->enabled || false === $constraint->enabled) {
            return;
        }

        if (!isset($_REQUEST['g-recaptcha-response'])) {
            $this->context->addViolation($constraint->message);

            return;
        }

        $verifyResponse = $this->httpGet(array(
                'secret' => $this->privateKey,
                'response' => $_REQUEST['g-recaptcha-response'])
        );
        $responseData = json_decode($verifyResponse);
        if (!$responseData->success) {
            $this->context->addViolation($constraint->message);
        }
    }

    private function httpGet(array $parameters)
    {
        $url = sprintf('%s?%s', self::RECAPTCHA_URL, http_build_query($parameters));

        return file_get_contents($url);
    }
}
