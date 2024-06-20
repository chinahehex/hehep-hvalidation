<?php
namespace hehe\core\hvalidation\annotation;

use hehe\core\hcontainer\ann\base\Annotation;
use Attribute;
/**
 * 验证注解器
 * @Annotation("hehe\core\hvalidation\annotation\AnnValidatorProcessor")
 */
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
    public function __construct($value = null,string $on = null,$goon = null,string $when = null,string $name = null,$validator = null,string $message = null)
    {
        $this->injectArgParams(func_get_args(),'message');
    }

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
                $arg_params = (new \ReflectionClass(get_class($this)))->getConstructor()->getParameters();
                foreach ($arg_params as $index => $param) {
                    $name = $param->getName();
                    $value = null;
                    if (isset($args[$index])) {
                        $value = $args[$index];
                    } else {
                        if ($param->isDefaultValueAvailable()) {
                            $value = $param->getDefaultValue();
                        }
                    }

                    if (!is_null($value)) {
                        $values[$name] = $value;
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
