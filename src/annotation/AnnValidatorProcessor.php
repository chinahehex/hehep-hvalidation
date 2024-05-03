<?php
namespace hehe\core\hvalidation\annotation;

use hehe\core\hannotation\base\AnnotationProcessor;
use hehe\core\hvalidation\Validation;


class AnnValidatorProcessor extends AnnotationProcessor
{
    /**
     * 验证器规则列表
     * @var array
     */
    protected $validators = [];

    /**
     * 注解转换成验证规则
     * @param object $annotation
     */
    protected function toValidatRule($annotation)
    {
        $annotationAttrs = $this->getAttribute($annotation);
        $validatorRule = [];

        $validatorRule[0] = $annotationAttrs['name'];
        $validatorRule[1] = $annotationAttrs['validator'];
        if ($annotationAttrs['on'] !== null) {
            $validatorRule['on'] = $annotationAttrs['on'];
        }

        if ($annotationAttrs['goon'] !== null) {
            $validatorRule['goon'] = $annotationAttrs['goon'];
        }

        return $validatorRule;
    }

    // 属性处理
    protected function annotationHandlerAttribute($annotation,$clazz,$attribute)
    {
        $validatorRule = $this->toValidatRule($annotation);
        $validatorRule[0] = $attribute;

        $this->validators[$clazz][] = $validatorRule;
    }

    protected function annotationHandlerMethod($annotation,$clazz,$method)
    {
        $validatorRule = $this->toValidatRule($annotation);
        $this->validators[$clazz .'@'.$method][] = $validatorRule;
    }

    public function getAnnotationors(string $class_key = '')
    {
        if (isset($this->validators[$class_key])) {
            return $this->validators[$class_key];
        } else {
            return [];
        }
    }
}
