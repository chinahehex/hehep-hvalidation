<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 过滤字段
 *<B>说明：</B>
 *<pre>
 * 主要用于格式化属性值，比如去除字符串两边空格,反序列号
 *</pre>
 *<B>示例：</B>
 *<pre>
 *  格式:['phone',[ ['filter','call'=>'json_decode','params'=>['{{0}}',true]]] ],
 *</pre>
 */
class FilterValidator extends Validator
{
    /**
     * 函数或对象
     *<B>说明：</B>
     *<pre>
     *　 call_user_func_array 标准格式,一般为[类或对象,方法名]
     *</pre>
     * @var array
     */
    protected $call = null;

    /**
     * call 参数
     *<B>说明：</B>
     *<pre>
     *　 略
     *</pre>
     * @var array
     */
    protected $params = [];

    /**
     * call value 参数的位置
     *<B>说明：</B>
     *<pre>
     *　 比如trim($value), 第一个参数0
     *</pre>
     * @var int
     */
    protected $valuePos = null;

    /**
     * call value 参数的替换标识
     *<B>说明：</B>
     *<pre>
     *　 默认{{0}}
     *</pre>
     * @var string
     */
    protected $valueFlag = '{{0}}';

    /**
     * 构造方法
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param array $config　类属性
     * @param ValidateManager $validateManager　验证管理类
     */
    public function __construct($config = [],ValidateManager $validateManager = null)
    {

        parent::__construct($config,$validateManager);

        // 查找value 在 call 参数的位置
        $valuePos = 0;
        if (empty($this->params) || !isset($this->valuePos)) {
            $pos = array_search($this->valueFlag,$this->params);
            if ($pos !== false) {
                $valuePos = $pos;
            }
        }

        $this->valuePos = $valuePos;
    }


    /**
     * 验证对象方法
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param object $model 需验证对象
     * @param array $attrs 属性名
     * @return ValidateResult
     */
    public function validateAttrs($model,$attrs)
    {
        // 复制一份参数
        $params = $this->params;
        if (empty($params)) {
            $params = [];
        }

        foreach ($attrs as $attr) {
            $params[$this->valuePos] = $model->$attr;
            $model->$attr = call_user_func_array($this->call,$params);
        }

        return new ValidateResult(true);
    }

    /**
     * 验证值接口
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param string|array $value
     * @param string $name 属性名
     * @return boolean
     */
    protected function validateValue($value,$name = null)
    {
        return true;
    }


}