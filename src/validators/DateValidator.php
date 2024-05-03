<?php
namespace hehe\core\hvalidation\validators;
use DateTime;
use hehe\core\hvalidation\base\Validator;

/**
 * 日期验证类
 *<B>说明：</B>
 *<pre>
 * 略
 *</pre>
 *<B>示例：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['date','format'=>'Y-m-d H:i:s']],'message'=>'请输入一个合法的日期格式地址']
 *</pre>
 */
class DateValidator extends Validator
{

    /**
     * 邮件格式
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    public $format = 'Y-m-d';

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
        $this->addParam('format',$this->format);
        $date = DateTime::createFromFormat($this->format, $value);
        $errors = DateTime::getLastErrors();
        if ($date === false || $errors['error_count'] || $errors['warning_count']) {
            return false;
        } else {
            return true;
        }
    }


}