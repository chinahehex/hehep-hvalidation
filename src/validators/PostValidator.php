<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 邮编验证类
 *<B>说明：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['post']],'message'=>'请输入一个6位的邮编号']
 * 0-9　数字,不支持小数点
 *</pre>
 */
class PostValidator extends Validator
{

    /**
     * 邮编验证正则
     *<B>说明：</B>
     *<pre>
     *  6　位邮编
     *</pre>
     * @var string
     */
    public $pattern = '/^[0-9]{6}$/';

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
