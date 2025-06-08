<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 验证是否为空
 *<B>说明：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['empty']],'message'=>'输入的值必须为空']
 *</pre>
 */
class EmptyValidator extends Validator
{

    /**
     * 验证接口
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
        if (empty($value)) {
            return true;
        } else {
            return false;
        }
    }


}
