<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 日期范围验证类
 *<B>说明：</B>
 *<pre>
 * 略
 *</pre>
 *<B>示例：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['rangedate','min'=>'2019-01-01','max'=>'2019-01-05']],'message'=>'请输入一个范围介于 {min} 和 {max} 之间的日期']
 *</pre>
 */
class RangeDateValidator extends Validator
{
    protected $min = null;

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
        $validDatetime = strtotime($value);
        $result = true;
        if (!is_null($this->min)) {
            $mintime = strtotime($this->min);
            if ($validDatetime <= $mintime) {
                $result = false;
            }
        }

        if (!is_null($this->max)) {
            $maxtime = strtotime($this->max);
            if ($validDatetime >= $maxtime) {
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
