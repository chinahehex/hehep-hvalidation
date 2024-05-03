<?php
namespace hehe\core\hvalidation\base;

/**
 * 验证结果类
 *<B>说明：</B>
 *<pre>
 * 略
 *</pre>
 */
class ValidateResult
{
    /**
     * 验证结果
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @var boolean
     */
    protected $result = true;

    /**
     * 验证结果其他参数
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @var array
     */
    protected $params = [];

    /**
     * 验证结果提示消息
     *<B>说明：</B>
     *<pre>
     *　验证不通过后,将返回消息
     *</pre>
     * @var string
     */
    protected $message = '';

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
     * 默认消息
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    protected $defaultMessage = '';

    /**
     * 构造方法
     *<B>说明：</B>
     *<pre>
     * 略
     *</pre>
     * @param boolean $result
     * @param string $message
     * @param array $params
     */
    public function __construct($result,$message = '',$params = [],$code = null,$defaultMessage = '')
    {
        $this->result = $result;
        $this->message = $message;
        $this->params = $params;
        $this->code = $code;
        $this->defaultMessage  = $defaultMessage;
    }

    /**
     * 获取提示消息
     *<B>说明：</B>
     *<pre>
     * 略
     *</pre>
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * 获取验证结果参数
     *<B>说明：</B>
     *<pre>
     * 略
     *</pre>
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * 获取提示消息
     *<B>说明：</B>
     *<pre>
     * 略
     *</pre>
     * @param boolean $result 验证结果
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * 返回验证结果
     *<B>说明：</B>
     *<pre>
     * 略
     *</pre>
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * 返回错误码
     *<B>说明：</B>
     *<pre>
     * 略
     *</pre>
     */
    public function getCode()
    {
        return $this->code;
    }

    public function getDefaultMessage()
    {
        return $this->defaultMessage;
    }

}
