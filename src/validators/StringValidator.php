<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 验证基类
 *<B>说明：</B>
 *<pre>
 * 规则格式:
 * ['attrs',[['string']],'message'=>'请输入字符串']
 *</pre>
 */
class StringValidator extends Validator
{

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
    protected function validateValue($value,$name = null)
    {
        if (is_string($value)) {
            return true;
        } else {
            return false;
        }
    }


}