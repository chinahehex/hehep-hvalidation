<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;
use hehe\core\hvalidation\Validation;

/**
 * call_user_func_array 函数调用方式
 *<B>说明：</B>
 *<pre>
 * 规则格式:
 * ['attrs',[['string']],'message'=>'请输入字符串']
 *</pre>
 */
class CallValidator extends Validator
{
    /**
     * 验证值接口
     *<B>说明：</B>
     *<pre>
     *　 call_user_func_array 标准格式,一般为[类或对象,方法名]
     *</pre>
     * @var array
     */
    protected $func = null;

    /**
     * call 参数
     *<B>说明：</B>
     *<pre>
     *　 略
     *</pre>
     * @var array
     */
    public $params = [];

    public function __construct(array $config = [],Validation $validation = null)
    {
        parent::__construct($config,$validation);

        // 计算func 规则
        if (!empty($this->func)) {
            $func = $this->func;
            if (is_string($func)) {
                if (strpos($func,"@@") !== false) {
                    $func_params = explode('@@',$func);
                    $formator_class = $func_params[0];
                    if (strpos($formator_class,'\\') === false) {
                        $formation_namespace = implode('\\',explode('\\',Validation::class,-1));
                        $formator_class = $formation_namespace . '\\validators\\' . ucfirst($formator_class);
                    }

                    $this->func = [$formator_class,$func_params[1]];
                } else if (strpos($func,"@") !== false) {
                    $func_params = explode('@',$func);
                    $formator_class = $func_params[0];
                    if (strpos($formator_class,'\\') === false) {
                        $formation_namespace = implode('\\',explode('\\',Validation::class,-1));
                        $formator_class = $formation_namespace . '\\validators\\' . ucfirst($formator_class);
                    }
                    $this->func = [$formator_class,$func_params[1]];
                }
            }
        }

    }

    /**
     * 验证值接口
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param string|array $value
     * @param string $name 属性名
     * @return boolean
     */
    protected function validateValue($value,$name = null):bool
    {
        $result = call_user_func_array($this->func,[$value,$this]);

        return $result;
    }


}
