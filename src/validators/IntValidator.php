<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 整型数验证类
 *<B>说明：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['int','pattern'=>'']],'message'=>'请输入一个整数']
 *</pre>
 */
class IntValidator extends Validator
{

    /**
     * 整数验证正则
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    public $pattern = '/^-?\d+$/';

    /**
     * 正负符号
     * @var string
     */
    public $symbol = '';


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
        if ($this->symbol === '-') {
            $pattern = '/^-\d+$/';
        } else if ($this->symbol === '+') {
            $pattern = '/^\d+$/';
        } else {
            $pattern = $this->pattern;
        }

        return preg_match($pattern, $value) === 1;
    }


}
