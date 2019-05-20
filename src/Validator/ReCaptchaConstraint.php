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

/**
 * ReCaptcha Constraint.
 *
 * @author Ilya Pokamestov <dario_swain@yahoo.com>
 */
class ReCaptchaConstraint extends Constraint
{
    /** @var string */
    public $message = 'ds.recaptcha.invalid';
    /** @var bool $enabled */
    public $enabled = true;
    /** @var string */
    public $privateKey = '';

    /** @return string */
    public function validatedBy()
    {
        return 'DS\Component\ReCaptchaValidator\Validator\ReCaptchaValidator';
    }
}
