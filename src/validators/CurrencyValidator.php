<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 货币验证类
 *<B>说明：</B>
 *<pre>
 * 支持http.https 格式
 *  规则格式:
 * ['attrs',[['currency','pattern'=>'','decimalPoint'=>2]],'message'=>'请输入一个合法的货币类型数值(保留三位小数)']
 *</pre>
 */
class CurrencyValidator extends Validator
{

    /**
     * 货币验证正则
     *<B>说明：</B>
     *<pre>
     *  表达式中可用{point}　代替小数点后几位
     *</pre>
     * @var string
     */
    public $pattern = '/^[-\+]?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,{point}})?$/';

    /**
     * 小数点最多几位
     *<B>说明：</B>
     *<pre>
     *  默认两位
     *</pre>
     * @var array
     */
    public $decimalPoint = 2;


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
        if (strpos($this->pattern, '{point}') !== false) {
            $pattern = str_replace('{point}', $this->decimalPoint , $this->pattern);
        } else {
            $pattern = $this->pattern;
        }

        return preg_match($pattern, $value) === 1;
    }


}
