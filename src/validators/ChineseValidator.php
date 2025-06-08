<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 中文验证类
 *<B>说明：</B>
 *<pre>
 * 略
 *</pre>
 *<B>示例：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['cn']],'message'=>'请输入一个合法的中文字符']
 *</pre>
 */
class ChineseValidator extends Validator
{

    /**
     * 中文正则表达式
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    protected $pattern = '/^[\x{4e00}-\x{9fa5}]+$/u';

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
