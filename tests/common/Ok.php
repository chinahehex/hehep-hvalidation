<?php
namespace hvalidation\tests\common;
use hehe\core\hcontainer\ann\base\Ann;
use hehe\core\hcontainer\ann\base\Annotation;

use Attribute;

/**
 * @Annotation("hehe\core\hvalidation\annotation\AnnValidatorProcessor")
 */
#[Attribute]
class Ok
{

    public $name;

    public $age;

    public $type;

    public $date;

    public function __construct(...$value)
    {
        var_dump($value);
        var_dump($this->getArgParams($value,'name'));
    }

//    public function __construct($value = null,?int $age = null,string $type = null,string $date = null,string $name = null)
//    {
//        var_dump(func_get_args());
//    }


    /**
     * 获取格式化后参数
     * @param array $args 构造参数
     * @param string $value_name 第一个构造参数对应的属性名
     * @return array
     * @throws \ReflectionException
     */
    protected function getArgParams(array $args = [],string $value_name = ''):array
    {
        // php 注解
        $values = [];
        if (!empty($args)) {
            if (is_string($args[0]) || is_null($args[0])) {
                foreach ($args as $index=>$val) {
                    if (is_numeric($index)) {
                       if ($index == 0) {
                           $values[$value_name] = $args[$index];
                       }
                    } else {
                        $values[$index] = $args[$index];
                    }
                }
            } else if (is_array($args[0])) {
                $values = $args[0];
            }
        }

        $value_dict = [];
        foreach ($values as $name => $value) {
            if (is_null($value)) {
                continue;
            }

            if ($name == 'value' && $value_name != '') {
                $value_dict[$value_name] = $value;
            } else {
                $value_dict[$name] = $value;
            }
        }


        return $value_dict;
    }

    /**
     * 获取格式化后参数
     * @param array $args 构造参数
     * @param string $value_name 第一个构造参数对应的属性名
     */
    protected function injectArgParams(array $args = [],string $value_name = ''):void
    {
        $values = $this->getArgParams($args,$value_name);

        foreach ($values as $name=>$value) {
            $this->{$name} = $value;
        }
    }
}
