<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 数字验证类
 *<B>说明：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['number']],'message'=>'请输入一个合法的0-9数字']
 * 0-9　数字,不支持小数点
 *</pre>
 */
class NumberValidator extends Validator
{

    /**
     * 数字验证正则
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    public $pattern = '/^\d+$/';

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
        return preg_match($this->pattern, $value) === 1;
    }


}
