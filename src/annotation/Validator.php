<?php
namespace hehe\core\hvalidation\annotation;

use hehe\core\hcontainer\ann\base\Annotation;
use Attribute;
/**
 * 验证注解器
 * @Annotation("hehe\core\hvalidation\annotation\AnnValidatorProcessor")
 */
#[Annotation("hehe\core\hvalidation\annotation\AnnValidatorProcessor")]
#[Attribute]
class Validator
{

    // 验证器
    public $validator;

    // 提示消息
    public $message;

    // 满足触发规则条件
    public $when;

    // 场景
    public $on;

    // 验证器错误后，是否继续验证其他验证器
    public $goon;

    /**chua
     * 验证的键名
     * @var string
     */
    public $name;

    /**
     * 构造方法
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @param array $attrs
     */
    public function __construct(...$value)
    {
        $this->injectArgParams($value,'message');
    }

    /**
     * 获取格式化后参数
     * @param array $args 构造参数
     * @param string $value_name 第一个构造参数对应的属性名
     * @return array
     */
    protected function getArgParams(array $args = [],string $value_name = 'message'):array
    {
        // php 注解
        $values = [];
        if (!empty($args)) {
            if (isset($args[0]) && (is_string($args[0]) || is_null($args[0]))) {
                foreach ($args as $index=>$val) {
                    if (is_numeric($index)) {
                        if ($index == 0) {
                            $values[$value_name] = $args[$index];
                        }
                    } else {
                        $values[$index] = $args[$index];
                    }
                }
            } else if (isset($args[0]) && is_array($args[0])) {
                $values = $args[0];
            } else {
                $values = $args;
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
