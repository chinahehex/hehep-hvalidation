<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 浮点数验证类
 *<B>说明：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['float','pattern'=>'','decimalPoint'=>2]],'message'=>'请输入一个保留两位小数浮点数']
 *</pre>
 */
class FloatValidator extends Validator
{

    /**
     * 浮点数验证正则
     *<B>说明：</B>
     *<pre>
     *  表达式中可用{point}　代替小数点后几位
     *</pre>
     * @var string
     */
    public $pattern = '/^[{symbol}]?(([1-9]{1}\d*)|([0]{1}))(\.(\d){point})?$/';

    /**
     * 小数点最多几位
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var int
     */
    public $decimalPoint = 2;

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
    protected function validateValue($value,$name = null):bool
    {

        if ($this->decimalPoint === null) {
            $point = '+';
        } else {
            $point = '{1,' . $this->decimalPoint . '}';
        }

        if (strpos($this->pattern, '{point}') !== false) {
            $pattern = str_replace('{point}', $point , $this->pattern);
        } else {
            $pattern = $this->pattern;
        }

        if ($this->symbol === '-') {
            $pattern = str_replace('{symbol}', '-' , $pattern);
        } else if ($this->symbol === '+') {
            $pattern = str_replace('{symbol}', '+' , $pattern);
        } else {
            $pattern = str_replace('{symbol}', '-\+' , $pattern);
        }

        return preg_match($pattern, $value) === 1;
    }

}
