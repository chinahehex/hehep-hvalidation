<?php
namespace hehe\core\hvalidation\annotation;
use hehe\core\hcontainer\ann\base\Annotation;
use Attribute;
/**
 * @Annotation("hehe\core\hvalidation\annotation\AnnValidatorProcessor")
 */
#[Annotation("hehe\core\hvalidation\annotation\AnnValidatorProcessor")]
#[Attribute]
class RegValid extends Validator
{
    public $validator = 'reg';

}
