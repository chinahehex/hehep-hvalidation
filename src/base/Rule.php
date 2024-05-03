<?php
namespace hehe\core\hvalidation\base;

/**
 * 验证规则类
 *<B>说明：</B>
 *<pre>
 * 验证规则格式:
 * ['属性名',[验证类型],'参数1','参数2','参数3']
 *</pre>
 *<B>示例：</B>
 *<pre>
 *  略
 *</pre>
 */
class Rule
{
    /**
     * 属性名列表
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var array
     */
    protected $attrs = [];

    /**
     * 验证类型
     *<B>说明：</B>
     *<pre>
     *  格式
     * [
     *    ['boolean','skipOnEmpty'=>false]
     * ]
     *</pre>
     * @var array
     */
    protected $validateTypes = [];

    /**
     * 当验证错误是是否继续验证
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var boolean
     */
    protected $goon = true;

    /**
     * 错误消息
     *<B>说明：</B>
     *<pre>
     *  略
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
     * 场景
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    protected $on = '';

    /**
     * 规则条件
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var
     */
    protected $when = null;

    /**
     * 默认场景
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    const DEFUALT_SCENE = 'default';

    /**
     * 构造方法
     *<B>说明：</B>
     *<pre>
     * 初始化属性
     *</pre>
     * @param array $ruleConfig 配置信息
     */
    public function __construct($ruleConfig = [])
    {

        $this->validateTypes = is_array($ruleConfig[1]) ? $ruleConfig[1] : [$ruleConfig[1]];
        $this->attrs = is_array($ruleConfig[0]) ? $ruleConfig[0] : [$ruleConfig[0]];

        unset($ruleConfig[0],$ruleConfig[1]);

        $this->attributes($ruleConfig);
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
    public function attributes($attributes)
    {
        foreach ($attributes as $attribute => $value) {
            $this->$attribute = $value;
        }

        return $this;
    }

    /**
     * 验证错误后，是否继续
     *<B>说明：</B>
     *<pre>
     * 略
     *</pre>
     * @return boolean
     */
    public function getGoonStatus()
    {
        return $this->goon;
    }

    /**
     * 获取验证类型
     *<B>说明：</B>
     *<pre>
     * 略
     *</pre>
     * @return array
     */
    public function getValidateTypes()
    {
        return $this->validateTypes;
    }

    /**
     * 获取提示信息
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
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

    /**
     * 获取属性值
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param array $attributes 格式 ['key'=>'name',...]
     * @return array
     */
    public function getValues($attributes)
    {
        $values = [];

        foreach ($this->attrs as $name) {
            $values[$name] = isset($attributes[$name]) ? $attributes[$name] : null;
        }

        return $values;
    }

    /**
     * 是否有效规则
     *<B>说明：</B>
     *<pre>
     *　根据场景过滤出适合符合传入场景的rule
     *</pre>
     * @param array $scenes 场景
     * @param array|object $attributes 属性值
     * @return boolean
     */
    public function isActive($scenes = [],$attributes = [])
    {

        if (!empty($this->on) && ($this->on != self::DEFUALT_SCENE || !in_array($this->on,$scenes))) {
            return false;
        }

        if (!empty($this->when) && !call_user_func_array($this->when,[$this,$attributes])) {
            return false;
        }

        return true;
    }

    /**
     * 验证的属性名称
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @return array
     */
    public function getAttrs()
    {
        return $this->attrs;
    }

}
