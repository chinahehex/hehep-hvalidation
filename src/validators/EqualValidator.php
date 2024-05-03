<?php
namespace hehe\core\hvalidation\validators;
use Exception;
use hehe\core\hvalidation\base\Validator;

/**
 * 相等验证类
 *<B>说明：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['eq','value'=>20,'operator'=>'===']],'message'=>'您输入的值必须等于20']
 *</pre>
 */
class EqualValidator extends Validator
{
    /**
     * 比较值
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    protected $value = 0;

    /**
     * 操作符
     *<B>说明：</B>
     *<pre>
     *  支持==,===(全等于)
     *</pre>
     * @var string
     */
    protected $operator = '==';

    /**
     * 验证值接口
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param string $value
     * @param string $name 属性名
     * @return boolean
     * @throws Exception
     */
    protected function validateValue($value,$name = null)
    {
        if (!in_array($this->operator,['==','==='])) {
            throw  new Exception('validate type equal operator invalid');
        }

        $result = null;

        switch ($this->operator) {
            case '==':
                $result = $value == $this->value;
                break;
            case '===':
                $result = $value === $this->value;
                break;
        }

        if ($result === false) {
            $this->addParam('value',$this->value);
        }

        return $result;
    }


}