<?php
namespace hehe\core\hvalidation\validators;
use Exception;
use hehe\core\hvalidation\base\Validator;

/**
 * 比较值
 *<B>说明：</B>
 *<pre>
 * 略
 *</pre>
 *<B>示例：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['compare','operator'=>'gt','number'=>15]],'message'=>'请输入一个大于15的数值']
 * operator:大于(gt),大于等于(egt),小于(lt),小于等于(elt)
 *</pre>
 */
class CompareValidator extends Validator
{

    /**
     * 比较值
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var int
     */
    protected $number = 0;

    /**
     * 操作符
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var int
     */
    protected $operator = '';

    /**
     * 有效的操作符列表
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var int
     */
    protected $operatorList = ['gt','egt','lt','elt','eq','>','>=','<','<=','='];

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
        $this->addParam('number',$this->number);

        // 必须是有效的数值
        $reg = '/^[-\+]?\d+(\.\d+)?$/';
        if (preg_match($reg,$value) !== 1 || preg_match($reg,$this->number) !== 1) {
            return false;
        }

        if (!in_array($this->operator,$this->operatorList)) {
            throw  new Exception('validate type compare operator invalid');
        }

        $result = null;

        // 验证操作符
        switch ($this->operator) {
            // 大于
            case 'gt' :
            case '>' :
                $result = $value > $this->number;
                break;
            // 大于等于
            case 'egt' :
            case '>=' :
                $result = $value >= $this->number;
                break;
            // 小于
            case 'lt' :
            case '<' :
                $result = $value < $this->number;
                break;
            // 小于等于
            case 'elt' :
            case '<=' :
                $result = $value <= $this->number;
                break;
            // 小于等于
            case 'eq' :
            case '=' :
                $result = $value == $this->number;
                break;
        }

        return $result;
    }

}
