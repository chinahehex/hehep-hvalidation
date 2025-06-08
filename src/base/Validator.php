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
    public $hvalidation;

    /**
     * 验证规则对象
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
    protected $defmsg = '';

    /**
     * 错误码
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    protected $errCode = null;

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
     * @var ValidForm
     */
    public $validForm;

    /**
     * 构造方法
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param array $config 类属性
     * @param Validation $validation 验证管理类
     */
    public function __construct(array $config = [],Validation $validation = null)
    {
        // 属性赋值
        $this->setConfig($config);

        $this->validation = $validation;
    }

    /**
     * 给对象属性赋值
     *<B>说明：</B>
     *<pre>
     * 比较适合用于创建业务类
     *</pre>
     * @param array $config 属性
     */
    protected function setConfig(array $config  = []):void
    {
        foreach ($config as $key => $value) {
            $this->$key = $value;
        }
    }

    public function setValidForm(ValidForm $validForm):void
    {
        $this->validForm = $validForm;
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
    public function isEmpty($value):bool
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
    protected function validateValue($value,$name = null):bool
    {
        return true;
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
    public function validateValues($values = []):ValidateResult
    {
        $validateResultList = [];

        foreach ($values as $name=>$value) {
            $result = $this->validate($value,$name);
            $validateResultList[] = $result;
        }

        if (in_array(false,$validateResultList)) {
            return new ValidateResult(false,$this->getMessage(),[],$this->errCode,$this->getDefaultMessage());
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
    public function isSkip($value):bool
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
    public function validate($value,$name = null):bool
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
     * 获取错误消息
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @return string
     */
    public function getMessage():string
    {
        if (empty($this->message)) {
            return '';
        } else {
            return  $this->formatMessage($this->message,$this->_params);
        }
    }

    public function getDefaultMessage():string
    {
        if (empty($this->defmsg)) {
            return '';
        } else {
            return $this->formatMessage($this->defmsg,$this->_params);
        }
    }

    /**
     * 格式化消息
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @param string $message 验证方法名称
     * @param array|string $params 验证规则
     * @return string
     */
    public function formatMessage(string $message = '',$params = []):string
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
    public function countLength($value,$charset = "utf-8"):int
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
    public function addParam(string $key,$value):void
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
    public function addParams(array $params = []):void
    {
        $this->_params = $this->_params + $params;
    }

    public function getParams():array
    {
        return $this->_params;
    }

    public function getErrorCode()
    {
        return $this->errCode;
    }

}
