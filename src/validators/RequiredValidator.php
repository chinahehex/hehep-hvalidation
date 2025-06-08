<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 必填验证类
 *<B>说明：</B>
 *<pre>
 * 规则格式:
 * ['attrs',[['required']],'message'=>'你输入的值不能为空']
 *</pre>
 */
class RequiredValidator extends Validator
{
    /**
     * 当验证值为空时是否调用验证
     *<B>说明：</B>
     *<pre>
     *  true 表示　值为空时,不验证,false 表示值为空，继续验证
     *</pre>
     * @var boolean　
     */
    protected $skipOnEmpty = false;

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

        if ($this->isEmpty($value)) {
            return false;
        } else {
            return true;
        }
    }

}
