<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;
use hehe\core\hvalidation\Validation;

/**
 * in验证类
 *<B>说明：</B>
 *<pre>
 *  类似in_array 验证
 *</pre>
 *<B>示例：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['inlist','numbers'=>[1,2,3,4]]],'message'=>'请输入在1,2,3,5范围内的字符]
 *</pre>
 */
class InValidator extends Validator
{

    /**
     * 验证数值列表
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var array
     */
    protected $numbers = [];

    public function __construct(array $config = [],Validation $validation = null)
    {
        parent::__construct($config, $validation);

        if (is_string($this->numbers)) {
            $this->numbers = explode(',',$this->numbers);
        }
    }

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
        $result = true;
        $val_list = explode(',',$value);
        foreach ($val_list as $val) {
            if (!in_array($val,$this->numbers)) {
                $result = false;
                break;
            }
        }

        if ($result) {
            return true;
        } else {
            $this->addParam('numbers',implode(',',$this->numbers));
            return false;
        }
    }
}
