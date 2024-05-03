<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 邮件验证类
 *<B>说明：</B>
 *<pre>
 * 略
 *</pre>
 *<B>示例：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['email','pattern'=>'','fullPattern'=>'','allowName'=>true]],'message'=>'请输入一个合法的邮件地址']
 *</pre>
 */
class EmailValidator extends Validator
{

    /**
     * 邮箱正则表达式
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    public $pattern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';

    /**
     * 带名称邮箱正则表达式
     *<B>说明：</B>
     *<pre>
     * 邮件地址中允许名称(e.g. "John Smith <john.smith@example.com>")
     *</pre>
     * @var string
     */
    public $fullPattern = '/^[^@]*<[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?>$/';

    /**
     * 是否启用姓名正则
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var boolean
     */
    public $allowName = false;

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
        if (preg_match($this->pattern, $value)  || $this->allowName && preg_match($this->fullPattern, $value)) {
            return true;
        } else {
            return false;
        }
    }


}