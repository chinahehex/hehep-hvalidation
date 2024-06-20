<?php
namespace hehe\core\hvalidation\annotation;

use hehe\core\hcontainer\ann\base\AnnotationProcessor;
use hehe\core\hvalidation\Validation;

class AnnValidatorProcessor extends AnnotationProcessor
{
    /**
     * 注解转换成验证规则
     * @param object $annotation
     */
    protected function annotationToValidateRule($annotation)
    {
        $annAttrs = $this->getAttribute($annotation);
        $validateRule = [];
        $validateRule[0] = '';
        $validateRule[1] = [];

        $validator = '';
        $attr_names = ['name','validator','on','when','goon','message'];
        foreach ($attr_names as $key) {
            if (isset($annAttrs[$key])) {
                if ($key == 'name') {
                    $validateRule[0] = $annAttrs[$key];
                } else if ($key == 'validator') {
                    $validator = $annAttrs[$key];
                } else {
                    $validateRule[$key] = $annAttrs[$key];
                }
            }

            unset($annAttrs[$key]);
        }

        $validator_rule = $annAttrs;
        if (is_array($validator)) {
            $validateRule[1] = $validator;
        } else {
            array_unshift($validator_rule,$validator);
            $validateRule[1] = [$validator_rule];
        }

        return $validateRule;
    }

    // 属性处理
    protected function handleAnnotationProperty($annotation,string $class,string $property):void
    {
        $validatorRule = $this->annotationToValidateRule($annotation);
        $validatorRule[0] = $property;

        Validation::addRule($class,$validatorRule);
    }

    protected function handleAnnotationMethod($annotation,string $class,string $method):void
    {
        $validatorRule = $this->annotationToValidateRule($annotation);
        Validation::addRule($class .'@'.$method,$validatorRule);
    }
}
