<?php
namespace hehe\core\hvalidation\annotation;
use  hehe\core\hcontainer\ann\base\Annotation;
use Attribute;
/**
 * @Annotation("hehe\core\hvalidation\annotation\AnnValidatorProcessor")
 */
#[Attribute]
class EqualValid extends Validator
{
    public $validator = 'eq';

}
