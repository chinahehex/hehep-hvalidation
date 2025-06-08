<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;
use hehe\core\hvalidation\Validation;

/**
 * in验证类
 *<B>说明：</B>
 *<pre>
 *  类似in_array 验证
 *</pre>
 *<B>示例：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['vlist','validators'=>[ ['int'],['range','min'=>1,'max'=>10,] ] ]],'message'=>'请输入在1,2,3,5范围内的字符]
 *</pre>
 */
class VlistValidator extends Validator
{

    /**
     * 验证器列表
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var array
     */
    protected $validators = [];

    /**
     * 验证值接口
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param string $value
     * @param string $name 属性名
     * @return boolean
     */
    protected function validateValue($value,$name = null):bool
    {
        $validators = [];
        foreach ($this->validators as $validator_config) {
            $validateType = array_shift($validator_config);
            $validators[] = ($this->hvalidation)::makeValidator($validateType,$validator_config);
        }

        $val_list = [];
        if (is_string($value)) {
            $val_list = explode(',',$value);
        } else {
            $val_list = $value;
        }

        $result = true;
        foreach ($val_list as $val) {
            foreach ($validators as $validator) {
                if (!$validator->validateValue($val)) {
                    $result = false;
                    break;
                }
            }

            if (!$result) {
                break;
            }
        }

        return $result;
    }
}
