<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 身份证验证类
 *<B>说明：</B>
 *<pre>
 * 略
 *</pre>
 *<B>示例：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['card']],'message'=>'请输入一个合法的省身份证号']
 *</pre>
 */
class CardValidator extends Validator
{

    /**
     * 身份证正则表达式
     *<B>说明：</B>
     *<pre>
     *  造孽啊.....
     *</pre>
     * @var string
     */
    protected $pattern = '/(^\d{15}$)|(^\d{17}([0-9]|[Xx])$)/';

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