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
    protected $errCode = null;

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
    public function __construct($result,$message = '',$params = [],$errCode = null,$defaultMessage = '')
    {
        $this->result = $result;
        $this->message = $message;
        $this->params = $params;
        $this->errCode = $errCode;
        $this->defaultMessage  = $defaultMessage;
    }

    /**
     * 获取提示消息
     *<B>说明：</B>
     *<pre>
     * 略
     *</pre>
     */
    public function getMessage():string
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
    public function getParams():array
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
    public function setResult($result):void
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
    public function getResult():bool
    {
        return $this->result;
    }

    /**
     * 返回错误码
     *<B>说明：</B>
     *<pre>
     * 略
     *</pre>
     * @return int|string
     */
    public function getErrorCode()
    {
        return $this->errCode;
    }

    public function getDefaultMessage():string
    {
        return $this->defaultMessage;
    }

}
