<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 数值范围验证类
 *<B>说明：</B>
 *<pre>
 * 略
 *</pre>
 *<B>示例：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['range','min'=>6,'max'=>16]],'message'=>'请输入一个合法的6-16位数值']
 *</pre>
 *<B>日志：</B>
 *<pre>
 *  略
 *</pre>
 *<B>注意事项：</B>
 *<pre>
 *  略
 *</pre>
 */
class RangeValidator extends Validator
{

    /**
     * 最小数值
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var int
     */
    protected $min = 0;

    /**
     * 最大数值
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
        // 必须是有效的数值
        $reg = '/^[-\+]?\d+(\.\d+)?$/';
        if (preg_match($reg,$value) !== 1) {
            return false;
        }
       
        if ($value >= $this->min && $value <= $this->max) {
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