<?php
namespace hehe\core\hvalidation\annotation;
use  hehe\core\hannotation\base\Annotation;

/**
 * @Annotation("hehe\core\hvalidation\annotation\AnnValidatorProcessor")
 */
class RequiredValid extends AnnValidator
{
    public function __construct($attrs = [])
    {
        parent::__construct($attrs);
        $this->validator[0] = 'required';
    }
}
