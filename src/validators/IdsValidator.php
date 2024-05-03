<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * id 验证器
 *<B>说明：</B>
 *<pre>
 *  id 必须整型
 *</pre>
 *<B>示例：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['ids'],'message'=>'你输入id 格式错误']
 *</pre>
 */
class IdsValidator extends Validator
{
    public $pattern = '/^[1-9]{1}\d*$/';

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
        $ids = [];

        if (!is_array($value)) {
            $ids = explode(',',$value);
        } else {
            $ids = $value;
        }
        $result = true;

        foreach ($ids as $id) {
            if (preg_match($this->pattern, $id) !== 1) {
                $result = false;
                break;
            }
        }

        return $result;
    }
}