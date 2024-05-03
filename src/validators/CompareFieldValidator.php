<?php
namespace hehe\core\hvalidation\validators;
use Exception;
use hehe\core\hvalidation\base\Validator;

/**
 * 比较字段值
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
class CompareFieldValidator extends Validator
{

    /**
     * 比较的目标字段
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    protected $field = 0;

    /**
     * 比较类型
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    protected $comparetype = '';

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
     * 支持的操作符列表
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    protected $operatorList = ['gt','egt','lt','elt','eq','>','>=','<','<=','='];


    protected function getFormatValue($value)
    {

        switch ($this->comparetype) {
            case 'int':
                return floatval($value);
            case 'date':
                return strtotime($value);
            case 'str':
                return strval($value);
                break;
        }

        return floatval($value);
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
     * @throws Exception
     */
    protected function validateValue($value,$name = null)
    {
        $this->addParam('field2',$name);
        $this->addParam('field1',$this->field);

        $comparefieldValue = $this->getFormatValue($this->getAttribute($this->field));

        if (!in_array($this->operator,$this->operatorList)) {
            throw  new Exception('validate type compare operator invalid');
        }

        $result = false;
        $validValue = $this->getFormatValue($value);

        // 验证操作符
        if (in_array($this->operator,['gt','>'])) {
            $result = $validValue > $comparefieldValue;
        } elseif (in_array($this->operator,['egt','>='])) {
            $result = $validValue >= $comparefieldValue;
        } elseif (in_array($this->operator,['lt','<'])) {
            $result = $validValue < $comparefieldValue;
        } elseif (in_array($this->operator,['elt','<='])) {
            $result = $validValue <= $comparefieldValue;
        } elseif (in_array($this->operator,['eq'])) {
            $result = $validValue == $comparefieldValue;
        }

        return $result;
    }

}