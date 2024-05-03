<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 布尔验证类
 *<B>说明：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['boolean']],'message'=>'请输入一个合法的布尔值']
 *</pre>
 */
class BooleanValidator extends Validator
{

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
    protected function validateValue($value,$name = null)
    {
        if (is_bool($value)) {
            return true;
        } else {
            return false;
        }
    }


}