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
    protected $min = null;

    /**
     * 最小字符数
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var int
     */
    protected $max = null;


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
        $len = $this->countLength($value);

        $result = true;

        if (!is_null($this->min)) {
            if ($len < $this->min) {
                $result = false;
            }
        }

        if (!is_null($this->max)) {
            if ($len > $this->max) {
                $result = false;
            }
        }

        if ($result) {
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
