<?php
namespace hehe\core\hvalidation\base;

use hehe\core\hvalidation\Validation;

/**
 * 验证基类
 *<B>说明：</B>
 *<pre>
 * 子类继续成后，实现validateValue 方法即可
 *</pre>
 */
class Validator
{
    /**
     * 验证名称
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    protected $_name = '';

    /**
     * 验证规则类
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var Validation
     */
    protected $validation = null;

    /**
     * 验证错误提示信息
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    protected $message = '';

    /**
     * 默认消息
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    protected $defaultMessage = '';

    /**
     * 错误码
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    protected $code = null;

    /**
     * 当验证值为空时是否调用验证
     *<B>说明：</B>
     *<pre>
     *  true 表示　值为空时,不验证,false 表示值为空，继续验证
     *</pre>
     * @var bool
     */
    protected $skipOnEmpty = true;

    /**
     * 验证是否空方法
     *<B>说明：</B>
     *<pre>
     *  一般函数或[$this,'isEmpty']
     * 比例利用php 的empty 函数验证空值
     *</pre>
     * @var array|string
     */
    protected $isEmpty = null;

    /**
     * 结果是否非
     *<B>说明：</B>
     *<pre>
     * 如:!$result
     *</pre>
     * @var boolean true 表示结果取非值
     */
    protected $non = false;

    /**
     * 消息替换参数
     *<B>说明：</B>
     *<pre>
     * 在验证validateValue中给设置$_params值
     * ['min'=>'1','max'=>'10',..]
     *</pre>
     * @var array
     */
    protected $_params = [];

    /**
     * 当前验证的对象活属性
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var object|array
     */
    protected $attributes = null;

    /**
     * 构造方法
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param array $config 类属性
     * @param Validation $validation 验证管理类
     */
    public function __construct($config = [],Validation $validation = null)
    {
        // 属性赋值
        $this->_init($config);

        $this->validation = $validation;
    }

    public function setAttributes(&$attributes)
    {
        $this->attributes = $attributes;
    }

    protected function getAttribute($attrName)
    {
        $attrNameList = explode(',',$attrName);
        $attributeName = $attrNameList[0];
        if (is_object($this->attributes)) {
            $value = $this->attributes->$attributeName;
        } else {
            $value = $this->attributes[$attributeName];
        }

        foreach ($attrNameList as $attrName) {
            if (isset($value[$attrName])) {
                $value = $value[$attrName];
            } else {
                break;
            }
        }

        return $value;
    }

    /**
     * 判断给定的值是否为空
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param string|array $value
     * @return boolean true 表示为空,否则为false
     */
    public function isEmpty($value)
    {
        if ($this->isEmpty !== null) {
            return call_user_func($this->isEmpty, $value);
        } else {
            return $value === null || $value === [] || $value === '';
        }
    }

    /**
     * 验证方法接口
     *<B>说明：</B>
     *<pre>
     *　子类必须实现此方法
     *</pre>
     * @param string|array $value
     * @param string $name 属性名
     * @return boolean
     */
    protected function validateValue($value,$name = null)
    {
        return true;
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
        $values = [];
        foreach ($attrs as $attr) {
            $values[$attr] = $model->$attr;
        }

        return $this->validateValues($values);
    }

    /**
     * 验证多个值
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param array $values
     * @return ValidateResult
     */
    public function validateValues($values = [])
    {
        $validateResultList = [];

        foreach ($values as $name=>$value) {
            $result = $this->validate($value,$name);
            $validateResultList[] = $result;
        }

        if (in_array(false,$validateResultList)) {
            return new ValidateResult(false,$this->getMessage(),[],$this->code,$this->getDefaultMessage());
        } else {
            return new ValidateResult(true);
        }
    }

    /**
     * 是否跳过验证
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param string $value
     * @return boolean
     */
    public function isSkip($value)
    {
        // 验证是否空跳过
        if ($this->skipOnEmpty && $this->isEmpty($value)) {
            return true;
        }

        return false;
    }

    /**
     * 验证单值接口
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param string|array $value
     * @param string $name 属性名
     * @return boolean
     */
    public function validate($value,$name = null)
    {
        if ($this->isSkip($value)) {
            return true;
        }

        $result = $this->validateValue($value,$name);
        if ($this->non === true) {
            $result = !$result;
        }

        return $result;
    }

    /**
     * 给对象属性赋值
     *<B>说明：</B>
     *<pre>
     * 比较适合用于创建业务类
     *</pre>
     * @param array $attributes 属性
     * @return $this
     */
    protected function _init($attributes)
    {
        foreach ($attributes as $attribute => $value) {
            $this->$attribute = $value;
        }

        return $this;
    }

    /**
     * 获取错误消息
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @return string
     */
    public function getMessage()
    {
        $message = $this->message;

        if (empty($message)) {
            return '';
        }

        // 格式化消息
        $message = $this->formatMessage($message,$this->_params);
        return $message;
    }

    public function getDefaultMessage()
    {
        $message = $this->defaultMessage;

        if (empty($message)) {
            return '';
        }

        // 格式化消息
        $message = $this->formatMessage($message,$this->_params);
        return $message;
    }

    /**
     * 格式化消息
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @param string $message 验证方法名称
     * @param array $params 验证规则
     * @return string
     */
    public function formatMessage($message = '',$params = [])
    {

        if (empty($params)) {
            return $message;
        }

        if (is_string($params)) {
            $replaceList[] = $params;
        } else {
            $replaceList = $params;
        }

        $replace = [];
        foreach ($replaceList as $key=>$value) {
            $replace['{'.$key.'}'] = $value;
        }

        $message = strtr($message,$replace);
        return $message;
    }

    /**
     * 统计字符长度.
     *<B>说明：</B>
     *<pre>
     *  1、支持中文，英文的等等
     *  2、支持各种编码
     *</pre>
     * @param string $value 验证值
     * @param string $charset 字符编码
     * @return int
     */
    public function countLength($value,$charset = "utf-8")
    {
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $value, $match);
        return count($match[0]);
    }

    /**
     * 添加消息模板参数
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @param string $key 键
     * @param string $value 值
     * @return int
     */
    public function addParam($key,$value)
    {
        $this->_params[$key] = $value;
    }

    /**
     * 添加消息模板参数
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @param array $params 参数(e.g ['key'=>'admin',...])
     */
    public function addParams($params = [])
    {
        $this->_params = $this->_params + $params;
    }

    public function getParams()
    {
        return $this->_params;
    }

    public function getCode()
    {
        return $this->code;
    }

}
