<?php
namespace hehe\core\hvalidation\validators;
use Exception;
use hehe\core\hvalidation\base\Validator;

/**
 * 字符长度比较值
 *<B>说明：</B>
 *<pre>
 * 略
 *</pre>
 *<B>示例：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['length','operator'=>'gt','number'=>15]],'message'=>'请输入一个大于15的数值']
 * operator:大于(gt),大于等于(egt),小于(lt),小于等于(elt)
 *</pre>
 */
class LengthValidator extends Validator
{

    /**
     * 比较长度值
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
     * @var string
     */
    protected $operator = '';

    /**
     * 有效的操作符列表
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var array
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

        $len = $this->countLength($value);
        $this->addParam('number',$this->number);

        if (!in_array($this->operator,$this->operatorList)) {
            throw  new Exception('validate type length operator invalid');
        }

        $result = null;

        // 验证操作符
        switch ($this->operator) {
            // 大于
            case 'gt' :
            case '>' :
                $result = $len > $this->number;
                break;
            // 大于等于
            case 'egt' :
            case '>=' :
                $result = $len >= $this->number;
                break;
            // 小于
            case 'lt' :
            case '<' :
                $result = $len < $this->number;
                break;
            // 小于等于
            case 'elt' :
            case '<=' :
                $result = $len <= $this->number;
                break;
            // 小于等于
            case 'eq' :
            case '=' :
                $result = $len == $this->number;
                break;
        }

        return $result;
    }

}
