<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 固定电话验证类
 *<B>说明：</B>
 *<pre>
 * 略
 *</pre>
 *<B>示例：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['phone']],'message'=>'请输入一个合法的省身份证号']
 *</pre>
 */
class PhoneValidator extends Validator
{

    /**
     * 固定电话正则表达式
     *<B>说明：</B>
     *<pre>
     *  带区号座机号
     * e.g 021-11212121,0898-12121212
     *</pre>
     * @var string
     */
    protected $pattern = '/^([0-9]{3,4}-)?[0-9]{7,8}$/';

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
        $valid = preg_match($this->pattern, $value);
        return $valid === 1;
    }

}