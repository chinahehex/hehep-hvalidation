<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 字符长度验证类
 *<B>说明：</B>
 *<pre>
 * 略
 *</pre>
 *<B>示例：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['rangelen','min'=>6,'max'=>20]],'message'=>'请输入一个长度介于 6 和 20 之间的字符串']
 *</pre>
 */
class RangeLengthValidator extends Validator
{
    /**
     * 最小字符数
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var int
     */
    protected $min = 0;

    /**
     * 最小字符数
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var int
     */
    protected $max = 0;


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
        $len = $this->countLength($value);
       
        if ($len >= $this->min && $len <= $this->max) {
            return true;
        } else {
            $this->addParams([
                'min'=>$this->min,
                'max'=>$this->max
            ]);
            return false;
        }
    }

}