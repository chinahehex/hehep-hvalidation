<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 正则验证类
 *<B>说明：</B>
 *<pre>
 * 规则格式:
 * ['attrs',[['reg','pattern'=>'/^([0-9]{3,4}-)?[0-9]{7,8}$/']],'message'=>'请输入一个合法的邮件地址']
 *</pre>
 */
class RegularValidator extends Validator
{
    /**
     * 正则表达式
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    protected $pattern = '';

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
        $valid = preg_match($this->pattern, $value);
        return $valid === 1;
    }

}
