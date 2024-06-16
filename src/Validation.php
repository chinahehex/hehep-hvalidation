<?php
namespace hehe\core\hvalidation;
use Exception;
use hehe\core\hvalidation\base\Rule;
use hehe\core\hvalidation\base\ValidateResult;
use hehe\core\hvalidation\base\ValidationResult;
use hehe\core\hvalidation\base\Validator;

/**
 * 验证对象属性类
 *<B>说明：</B>
 *<pre>
 * 关键词:验证管理类,验证规则，验证结果,验证类型
 *
 * 验证规则(rule):
 * ['验证名称','验证类型','验证参数1','验证参数2','验证参数3','验证参数4',...],
 * 验证名称 支持数组
 * 验证类型必须是数组,格式如[['min','属性1','属性2']]
 *
 * 验证类型:
 * 请参考:validators 属性
 *</pre>
 *<B>示例：</B>
 *<pre>
 * e.g
 * $validateData = [
 *    'name'=>'admin',
 *    'userid'=>10,
 *    'age'=>20
 * ];
 *
 * $validateRules = [
 *     ['name',[['minlen','min'=>10,'max'=>20]],'msg'=>'请输入一个10-20位的字符串'],
 *     ['userid',[['!empty']],'msg'=>'user_id 不能为空'],
 *     ['age',[['number']],'msg'=>'请输入0-9的数字'],
 * ];
 *
 * $validation = new Validation();
 * $validateResult = $validation->validate($validateRules,$validateData);
 * if ($validateResult === false) {
 *     $validation->getFirstError();
 * }
 *
 *
 * e.g 验证多个属性
 * ['userid,name',[['!empty']],'msg'=>'参数不能为空'],
 *
 * e.g 定义多个验证类型，支持与或
 * ['name',[['!empty'],['minlen','min'=>10,'max'=>20]],'msg'=>'请输入一个10-20位的字符串']
 * ['name',['or',['boolean'],['minlen','min'=>10,'max'=>20]],'msg'=>'请输入一个10-20位的字符串或布尔型'],
 *
 * e.g 新增验证类型
 * $validation = new Validation();
 * $validation->addValidateType('customType','hehe\\core\\validate\\BooleanValidate','自定义消息内容');
 *
 * e.g 直接实例化验证类，调用验证类方法
 * $validation = new Validation();
 * $validate = $validation－>createValidator('range',['min'=>10,'max'=>20]);
 * $result = $validate->validate(20);
 *
 * e.g 快捷方式验证-直接调用静态方法
 * $result = Validation::number('12',['name'=>23232]);
 *
 * e.g 自定义外部验证方法
 * ['user',['&' [[$this,'test1']],['or',[[$this,'test2']],[[$this,'test3']]] ],'msg'=>'你hehe来,我hehe'],
 *
 * e.g 属性值作为参数注入验证类属性
 * ['age',[['number','attrs'=>['pattern'=>'names']]],'msg'=>'请输入0-9的数字'],
 *
 * e.g 设置验证规则场景,验证包括默认规则以及属于场景的验证规则
 * ['name',[ ['number']], 'on'=>'app'],
 *
 *
 * e.g 注解,属性,必须先是用use hehe\core\validation\annotation\BooleanValid;
 *
 * BooleanValid(msg="ture or false")
 * RequiredValid("ture or false")
 * RangeValid(min=10,max=20)
 * EgtValid(number=10)
 *
 *</pre>
 * @method boolean boolean($value = '',$params = [])
 * @method boolean string($value = '',$params = [])
 * @method boolean empty($value = '',$params = [])
 * @method boolean email($value = '',$params = [])
 * @method boolean required($value = '',$params = [])
 * @method boolean url($value = '',$params = [])
 * @method boolean currency($value = '',$params = [])
 * @method boolean number($value = '',$params = [])
 * @method boolean post($value = '',$params = [])
 * @method boolean float($value = '',$params = [])
 * @method boolean int($value = '',$params = [])
 * @method boolean date($value = '',$params = [])
 * @method boolean file($value = '',$params = [])
 *
 *
 * @method boolean en($value = '',$params = [])
 * @method boolean cn($value = '',$params = [])
 * @method boolean card($value = '',$params = [])
 * @method boolean phone($value = '',$params = [])
 * @method boolean mobile($value = '',$params = [])
 * @method boolean tel($value = '',$params = [])
 * @method boolean ip($value = '',$params = [])
 * @method boolean ip4($value = '',$params = [])
 * @method boolean ip6($value = '',$params = [])
 * @method boolean minlen($value = '',$params = [])
 * @method boolean maxlen($value = '',$params = [])
 * @method boolean eqlen($value = '',$params = [])
 *
 * @method boolean rangelen($value = '',$params = [])
 * @method boolean rangedate($value = '',$params = [])
 * @method boolean compare($value = '',$params = [])
 * @method boolean gt($value = '',$params = [])
 * @method boolean egt($value = '',$params = [])
 * @method boolean lt($value = '',$params = [])
 * @method boolean elt($value = '',$params = [])
 * @method boolean range($value = '',$params = [])
 * @method boolean alpha($value = '',$params = [])
 * @method boolean alphaNum($value = '',$params = [])
 * @method boolean alphaDash($value = '',$params = [])
 * @method boolean reg($value = '',$params = [])
 * @method boolean inlist($value = '',$params = [])
 * @method boolean vlist($value = '',$params = [])
 * @method boolean enum($value = '',$params = [])
 * @method boolean notin($value = '',$params = [])
 * @method boolean eq($value = '',$params = [])
 * @method boolean ids($value = '',$params = [])
 *
 * @static
 */
class Validation
{

    /**
     * 自定义验证器类
     * @var array
     */
    public $customValidators  = [];

    /**
     * 规则列表
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var array
     */
    public static $rules = [];

    /**
     * 验证类型列表
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param array
     */
    protected static $validators = [
        'boolean'=>['class'=>'BooleanValidator','message'=>'请输入一个布尔值'],
        'string'=>['class'=>'StringValidator','message'=>'请输入一个字符串'],
        'empty'=>['class'=>'EmptyValidator','message'=>'您输入的值必须为空'],
        'email'=>['class'=>'EmailValidator','message'=>'请输入正确格式的电子邮件'],
        'required'=>['class'=>'RequiredValidator','message'=>'必须字段'],
        'url'=>['class'=>'UrlValidator','message'=>'请输入正确格式url 地址'],
        'currency'=>['class'=>'CurrencyValidator','message'=>'请输入正确的货币格式'],
        'number'=>['class'=>'NumberValidator','message'=>'请输入合法的数字'],
        'post'=>['class'=>'PostValidator','message'=>'请输入6位的合法邮编'],
        'float'=>['class'=>'FloatValidator','message'=>'请输入合法的浮点数'],
        'int'=>['class'=>'IntValidator','message'=>'请输入合法的整数'],
        'date'=>['class'=>'DateValidator','message'=>'请输入合法的日期格式({format})'],
        'file'=>['class'=>'FileValidator','message'=>'上传的文件格式错误!'],

        'en'=>['class'=>'EnglishValidator','message'=>'请输入字符必须为英文!'],
        'cn'=>['class'=>'ChineseValidator','message'=>'请输入字符必须为中文!'],
        'card'=>['class'=>'CardValidator','message'=>'请输入15或18位身份证号码'],
        'phone'=>['class'=>'PhoneValidator','message'=>'请输入带区号的固定电话号码'],
        'mobile'=>['class'=>'MobileValidator','message'=>'请输入11位手机号码'],
        'tel'=>['class'=>'MobileValidator','message'=>'请输入11位手机号码'],
        'ip'=>['class'=>'IpValidator','message'=>'你的输入ip 格式有误'],
        'ip4'=>['class'=>'IpValidator', 'mode'=>'ip4','message'=>'你的输入ip 格式有误'],
        'ip6'=>['class'=>'IpValidator', 'mode'=>'ip6','message'=>'你的输入ip 格式有误'],
        'eqlen'=>['class'=>'LengthValidator', 'operator'=>'eq','message'=>'请输入一个长度是 {number} 的字符串'],
        'minlen'=>['class'=>'LengthValidator', 'operator'=>'egt','message'=>'请输入一个长度最少是 {number} 的字符串'],
        'maxlen'=>['class'=>'LengthValidator', 'operator'=>'elt','message'=>'请输入一个长度最多是 {number} 的字符串'],

        'rangelen'=>['class'=>'RangeLengthValidator','message'=>'请输入一个长度介于 {min} 和 {max} 之间的字符串'],
        'rangedate'=>['class'=>'RangeDateValidator','message'=>'请输入一个范围介于 {min} 和 {max} 之间的日期'],

        'compare'=>['class'=>'CompareValidator','message'=>'请输入合法的值！'],
        'gt'=>['class'=>'CompareValidator', 'operator'=>'gt','message'=>'请输入一个大于{number} 的数值！'],
        'egt'=>['class'=>'CompareValidator', 'operator'=>'egt','message'=>'请输入一个大于等于 {number} 的数值！'],
        'lt'=>['class'=>'CompareValidator', 'operator'=>'lt','message'=>'请输入一个小于 {number} 的数值！'],
        'elt'=>['class'=>'CompareValidator', 'operator'=>'elt','message'=>'请输入一个小于等于{number} 的数值！'],
        'range'=>['class'=>'RangeValidator','message'=>'请输入一个合法的{min}-{max}数值！'],

        'alpha'=>['class'=>'CharValidator', 'mode'=>'alpha','message'=>'请输入的字符必须包含字母字符！'],
        'alphaNum'=>['class'=>'CharValidator', 'mode'=>'alphaNum','message'=>'请输入的字符必须包含字母、数字！'],
        'alphaDash'=>['class'=>'CharValidator', 'mode'=>'alphaDash','message'=>'请输入的字符包含字母、数字、破折号（ - ）以及下划线（ _ ）！'],

        'eqstrfield'=>['class'=>'CompareFieldValidator', 'comparetype'=>'str','operator'=>'eq','message'=>'输入的{field1}与{field2}的值必须相等'],

        'eqintfield'=>['class'=>'CompareFieldValidator', 'comparetype'=>'int','operator'=>'eq','message'=>'输入的{field1}与{field2}的值必须相等'],
        'gtintfield'=>['class'=>'CompareFieldValidator', 'comparetype'=>'int','operator'=>'gt','message'=>'请输入{field2} 的值必须大于{field1}！'],
        'egtintfield'=>['class'=>'CompareFieldValidator', 'comparetype'=>'int','operator'=>'egt','message'=>'请输入{field2} 的值必须大于等于{field1}！'],
        'ltintfield'=>['class'=>'CompareFieldValidator', 'comparetype'=>'int','operator'=>'lt','message'=>'请输入{field2} 的值必须小于{field1}！'],
        'eltintfield'=>['class'=>'CompareFieldValidator', 'comparetype'=>'int','operator'=>'elt','message'=>'请输入{field2} 的值必须小于等于{field1}！'],

        'eqdatefield'=>['class'=>'CompareFieldValidator', 'comparetype'=>'date','operator'=>'eq','message'=>'输入的{field1}与{field2}的值必须相等'],
        'gtdatefield'=>['class'=>'CompareFieldValidator', 'comparetype'=>'date','operator'=>'gt','message'=>'请输入{field2} 的值必须大于{field1}！'],
        'egtdatefield'=>['class'=>'CompareFieldValidator', 'comparetype'=>'date','operator'=>'egt','message'=>'请输入{field2} 的值必须大于等于{field1}！'],
        'ltdatefield'=>['class'=>'CompareFieldValidator', 'comparetype'=>'date','operator'=>'lt','message'=>'请输入{field2} 的值必须小于{field1}！'],
        'eltdatefield'=>['class'=>'CompareFieldValidator', 'comparetype'=>'date','operator'=>'elt','message'=>'请输入{field2} 的值必须小于等于{field1}！'],

        'reg'=>['class'=>'RegularValidator','message'=>'请输入合法格式字符'],
        'inlist'=>['class'=>'InValidator','message'=>'请输入在{numbers}范围内的字符'],
        'enum'=>['class'=>'InValidator','message'=>'请输入在{numbers}范围内的字符'],
        'notin'=>['class'=>'InValidator', 'non'=>true,'message'=>'输入的值不能为{numbers}！'],
        'vlist'=>['class'=>'VlistValidator','message'=>'请输入合法格式字符'],
        'eq'=>['class'=>'EqualValidator','message'=>'请输入一个等于{number}的值'],
        'ids'=>['class'=>'IdsValidator','message'=>'请输入整型的值'],
        'filter'=>['class'=>'FilterValidator'],
    ];


    /**
     * 构造方法
     *<B>说明：</B>
     *<pre>
     * 略
     *</pre>
     * @param array $config 属性
     */
    public function __construct($config = [])
    {
        $this->_init($config);
    }

    /**
     * 创建当前类实例
     *<B>说明：</B>
     *<pre>
     * 略
     *</pre>
     * @param array $config 参数
     * @return $this
     */
    public static function make($config)
    {
        return new static($config);
    }

    /**
     * 给对象属性赋值
     *<B>说明：</B>
     *<pre>
     * 略
     *</pre>
     * @param array $attributes 属性列表
     * @return $this
     */
    protected function _init($attributes)
    {
        foreach ($attributes as $attribute => $value) {
            $this->$attribute = $value;
        }

        // 加载自定义格式化列表
        foreach ($this->customValidators as $validator_class) {
            /** @var Validator  $validator_class **/
            static::install($validator_class);
        }

        return $this;
    }

    protected static function buildCustomValidator($custom_validator)
    {
        $new_class_status = true;
        if (strpos($custom_validator,"@@") !== false) {
            list($custom_validator_class,$custom_validator_method) = explode("@@",$custom_validator);
            $new_class_status = false;
        } else if (strpos($custom_validator,"@") !== false) {
            list($custom_validator_class,$custom_validator_method) = explode("@",$custom_validator);

        } else {
            $custom_validator_class = $custom_validator;
        }

        if (empty($custom_validator_method)) {
            $custom_validator_method = 'install';
        }

        if ($new_class_status) {
            return [new $custom_validator_class(),$custom_validator_method];
        } else {
            return [$custom_validator_class,$custom_validator_method];
        }
    }

    /**
     * 添加验证规则
     *<B>说明：</B>
     *<pre>
     * 略
     *</pre>
     * @param string $clazz 目标类路径
     * @param array $rule 验证规则
     * @return $this
     */
    public static function addRule($clazz,$rule)
    {
        static::$rules[$clazz][] = $rule;
    }

    public static function getRule($clazz)
    {
        return isset(static::$rules[$clazz]) ? static::$rules[$clazz] : [];
    }

    /**
     * 添加验证类型
     *<B>说明：</B>
     *<pre>
     * 略
     *</pre>
     * @param string $validateType 验证类别名
     * @param string $validateClass 验证类
     * @param string $message 消息模板
     * @return $this
     */
    public function addValidateType($validateType,$validateClass,$message = '')
    {
        self::$validators[$validateType] = ['class'=>$validateClass,'message'=>$message];

        return $this;
    }
    

    /**
     * 获取有效的验证规则
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param array $rules 验证规则
     * @param array $scene 场景
     * @return Rule[]
     * @throws Exception
     */
    protected function getValidRules($rules,$scene = [],$attributes = [])
    {
        $ruleList = [];
        foreach ($rules as $rule) {
            if (is_array($rule) && isset($rule[0], $rule[1])) {
                $rule = new Rule($rule);
                if ($rule->isActive($scene,$attributes)) {
                    $ruleList[] = $rule;
                }
            } else {
                throw new Exception('Invalid validation rule: a rule must specify both attribute names and validator type.');
            }
        }

        return $ruleList;
    }

    /**
     * 验证值
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param array $rules 验证规则
     * @param array $attributes 格式 ['key'=>'name',...]
     * @param array $scenes 验证场景['场景1','场景2',...]
     * @return ValidationResult
     * @throws Exception
     */
    public function validate($rules,$attributes,$scenes = [])
    {

        // 获取注解验证规则
        if (empty($rules) && is_object($attributes)) {
            $rules = static::getRule(get_class($attributes));
        }

        // 获取有效的验证规则
        $rules = $this->getValidRules($rules,$scenes,$attributes);
        // 整体验证结果列表
        $validationResult = new ValidationResult();

        foreach ($rules as $rule) {
            $validatorTypes = $rule->getValidateTypes();
            /** @var ValidateResult $result */
            $validateResult = $this->validateRule($rule,$attributes,$validatorTypes);
            $validationResult->addValidatorResult($validateResult);
            // 验证通不过，而且不在继续下一次的验证
            if ($validateResult->getResult() === false && !$rule->getGoonStatus()) {
                break;
            }
        }

        return $validationResult;
    }

    /**
     * 单个规则验证
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param Rule $rule 验证规则对象
     * @param array $attributes 格式 ['key'=>'name',...]
     * @param array $validateTypes 格式 []
     * @return ValidateResult
     * @throws Exception
     */
    protected function validateRule(Rule $rule,$attributes,$validateTypes = [])
    {
        // 获取属性值
        $operator = '&';

        if (is_string($validateTypes[0])) {
            $operator = $validateTypes[0];
            array_shift($validateTypes);
        }

        $resultList = [];
        /** @var ValidateResult $result */
        // 批量验证类
        foreach ($validateTypes as $validateType) {

            if ($this->isResolveValidType($validateType)) {
                // 递归验证方法
                $result = $this->validateRule($rule,$attributes,$validateType);
            } else {
                $validType = $validateType[0];
                $validateConfig = array_slice($validateType, 1);

                // 获取其他属性，为验证类使用
                if (isset($validateConfig['attrs'])) {
                    $attrs = $validateConfig['attrs'];
                    unset($validateConfig['attrs']);
                    $attrsValues = $this->getValues($attrs,$attributes);
                    $validateConfig = array_merge($validateConfig,$attrsValues);
                }

                if (is_string($validType)) {
                    // 读取第一个字符
                    $nonsymbol = substr($validType,0, 1 );
                    if ($nonsymbol === '!') {
                        $validType = substr($validType,1);
                        $validateConfig['non'] = true;
                    }
                } else if (is_array($validType) || $validType instanceof \Closure) {
                    $validateConfig['func'] = $validType;
                    $validType = 'CallValidator';
                }

                // 创建验证类
                $validate = $this->createValidator($validType, $validateConfig);
                // 开始验证
                $result = $this->execValidator($rule,$attributes,$validate);
            }

            $resultList[] = $result;
        }

        if ($operator == '&') {
            return $this->resolveAndRuleResult($resultList,$rule);
        } else {
            return $this->resolveOrRuleResult($resultList,$rule);
        }
    }

    /**
     * @param Rule $rule 验证规则对象
     * @param array|object $attributes 格式 ['key'=>'name',...]
     * @param Validator $validate
     * @return ValidateResult
     */
    protected function execValidator($rule,$attributes,$validate)
    {
        $validate->setAttributes($attributes);
        if (is_object($attributes)) {
            $attrs = $rule->getAttrs();
            $result = $validate->validateAttrs($attributes,$attrs);
        } else {
            $values = $rule->getValues($attributes);
            $result = $validate->validateValues($values);
        }

        return $result;
    }

    /**
     * 获取属性值
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param array $attrs 格式 ['name',...]
     * @param object|array $attributes 对象
     * @return array
     */
    public function getValues($attrs,$attributes)
    {
        $values = [];

        if (is_object($attributes)) {
            foreach ($attrs as $attr) {
                $values[$attr] = $attributes->$attr;
            }
        } else {
            foreach ($attrs as $key=>$name) {
                $values[$key] = isset($attributes[$name]) ? $attributes[$name] : null;
            }
        }

        return $values;
    }


    /**
     * 解析Rule验证结果
     *<B>说明：</B>
     *<pre>
     *　解析与(and) Rule　验证结果
     *</pre>
     * @param ValidateResult[] $resultList 验证结果对象列表
     * @param Rule $rule 验证规则对象
     * @return ValidateResult
     */
    public function resolveAndRuleResult($resultList,Rule $rule)
    {
        /** @var ValidateResult $result*/
        $message = '';
        $defaultMessage = '';
        $err_code = null;
        $validResult = true;
        foreach ($resultList as $result) {
            if ($result->getResult() === false ) {
                $validResult = false;
                $message = $result->getMessage();
                $defaultMessage = $result->getDefaultMessage();
                $err_code = $result->getErrorCode();
                break;
            }
        }

        if ($validResult === false) {
            if (empty($message)) {
                $message = $rule->getMessage();
                if (empty($message)) {
                    $message = $defaultMessage;
                }
            }

            if (empty($err_code)) {
                $err_code = $rule->getErrorCode();
            }

            return new ValidateResult(false,$message,[],$err_code);
        } else {
            return new ValidateResult(true,'',[]);
        }
    }

    /**
     * 解析Rule验证结果
     *<B>说明：</B>
     *<pre>
     *　解析或(or) Rule　验证结果
     *</pre>
     * @param ValidateResult[] $resultList 验证结果对象列表
     * @param Rule $rule 验证规则对象
     * @return ValidateResult
     */
    protected function resolveOrRuleResult($resultList,Rule $rule)
    {
        /** @var ValidateResult $result*/
        $message = '';
        $validResult = false;
        $defaultMessage = '';
        $err_code = null;
        foreach ($resultList as $result) {
            if ($result->getResult() === true ) {
                $validResult = true;
                break;
            } else {
                $defaultMessage = $result->getDefaultMessage();
                $message = $result->getMessage();
                $err_code = $result->getErrorCode();
            }
        }

        if ($validResult === false) {
            if (empty($message)) {
                $message = $rule->getMessage();
                if (empty($message)) {
                    $message = $defaultMessage;
                }
            }

            if (empty($err_code)) {
                $err_code = $rule->getErrorCode();
            }

            return new ValidateResult(false,$message,[],$err_code);
        } else {
            return new ValidateResult(true,'',[]);
        }
    }

    /**
     * 是否需要解析验证类型
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param array $validateType 验证类型名称
     * @return boolean true 须解析，不是有效的验证方法,false 无须解析,有消息验证方法,可执行验证
     */
    protected function isResolveValidType($validateType)
    {
        $operatorCharacter  = $validateType[0];

        // 格式['user',['&', [], [], [] ]]
        // 格式['user',[[[]], [], [] ]]

        // 操作符为字符串,表示须继续解析验证类型

        // 操作符为数组,
        if (is_string($operatorCharacter)) {
            if ($operatorCharacter == '&' || $operatorCharacter == '|') {
                // 继续解析
                return true;
            }
        } else if (is_array($operatorCharacter)) {
            $operatorCharacter = $operatorCharacter[0];
            if (is_string($operatorCharacter) && ($operatorCharacter == '&' || $operatorCharacter == '|')) {
                return true;
            } else if (is_array($operatorCharacter)) {
                return true;
            }
        }

        return false;
    }

    /**
     * 创建验证类
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param string $validateType  验证类型名称
     * @param array $config 配置
     * @return Validator|null
     * @throws Exception 验证类类不存在
     */
    public function createValidator($validateType,$config = [])
    {
        $config = static::getValidateConfig($validateType,$config);
        $validatorclass = $config['class'];
        $validate = new $validatorclass($config,$this);
        $validate->hvalidation = static::class;

        return $validate;
    }

    /**
     * 创建验证类
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param string $validateType  验证类型名称
     * @param array $config 配置
     * @return Validator|null
     * @throws Exception 验证类类不存在
     */
    public static function makeValidator($validateType,$config = [])
    {

        $config = static::getValidateConfig($validateType,$config);
        $validatorclass = $config['class'];
        $validate = new $validatorclass($config,null);
        $validate->hvalidation = static::class;

        return $validate;
    }

    /**
     * 验证类快捷方式
     *<B>说明：</B>
     *<pre>
     *　一般用于单值验证
     *</pre>
     * @param string $validateType  方法名
     * @param array $params 方法参数
     * @return boolean
     * @throws Exception
     */
    public static function __callStatic($validateType, $params)
    {
        if (!isset(self::$validators[$validateType])) {
            throw new Exception('method not exists:' . __CLASS__ . '->' . $validateType);
        }

        $config = isset($params[1]) ? $params[1] : [];

        /**@var Validator $validator*/
        $validator = static::makeValidator($validateType,$config);

        return $validator->validate($params[0]);
    }

    /**
     * 验证类快捷方式
     *<B>说明：</B>
     *<pre>
     *　一般用于单值验证
     *</pre>
     * @param string $validateType  方法名
     * @param array $params 方法参数
     * @return boolean
     * @throws Exception
     */
    public function __call($validateType, $params)
    {
        if (!isset(self::$validators[$validateType])) {
            throw new Exception('method not exists:' . __CLASS__ . '->' . $validateType);
        }

        $config = isset($params[1]) ? $params[1] : [];

        /**@var Validator $validator*/
        $validator = $this->createValidator($validateType,$config);

        return $validator->validate($params[0]);
    }

    protected static function getValidateConfig($validateType,$config = [])
    {
        if (isset(self::$validators[$validateType])) {
            $class = self::$validators[$validateType];
            if (!isset($class['defaultMessage'])) {
                if (isset($class['message'])) {
                    $class['defaultMessage'] = $class['message'];
                    unset($class['message']);
                }
            }

        } else {
            $class = $validateType;
        }

        if (is_array($class) && isset($class['class'])) {
            $validatorclass = $class['class'];
            $config = array_merge($class,$config);
            unset($class['class']);
        } else {
            $validatorclass = $class;
        }

        if (strpos($validatorclass,'\\') === false) {
            $validatorclass = __NAMESPACE__ . '\\validators\\' . ucfirst($validatorclass);
        }

        $config['_name'] = $validateType;
        $config['class'] = $validatorclass;

        return $config;
    }

    /**
     * 安装验证器
     * @param string|array $target_namespace 目标类命名空间路径
     * @param bool $only_target_class 是否只安装目标类,true 只安装目标类,false 安装目标类位置的所有类
     * @param bool $sub_dir 是否搜索子目录
     * @param string $suffix 验证器名称后缀
     */
    public static function install($target_namespace,$only_target_class = true,$sub_dir = false,$suffix = 'Validator')
    {
        $suffix_preg = '/(.+)' . $suffix .'.php$/';

        // 判断是命令空间还是路径
        if (is_array($target_namespace)) {
            $only_target_class = false;
            $reflectionClass = new \ReflectionClass($target_namespace);
            list($base_path,$base_class_namespace) = $target_namespace;
        } else {
            $reflectionClass = new \ReflectionClass($target_namespace);
            $base_path = dirname($reflectionClass->getFileName());
            $base_class_namespace = str_replace(DIRECTORY_SEPARATOR,'\\',dirname(str_replace('\\',DIRECTORY_SEPARATOR,$target_namespace)));
        }

        $find_class = function($base_class_namespace,$base_path,$suffix_preg,$is_read_dir) use(&$find_class) {
            $fileList = scandir($base_path);
            $classList = [];
            foreach ($fileList as $filename) {
                if ($filename === '.' || $filename === '..'){
                    continue;
                }

                $filePath = $base_path . DIRECTORY_SEPARATOR . $filename;
                if (is_dir($filePath)) {
                    if ($is_read_dir) {
                        $read_dir = false;
                        $dir_class_list = $find_class($base_class_namespace . '\\' . $filename,$filePath,$suffix_preg,$read_dir);
                        $classList = array_merge($dir_class_list,$classList);
                    } else {
                        continue;
                    }
                } else {
                    // 判断后缀
                    if (preg_match($suffix_preg, $filename, $matches)) {
                        $classNamespace = $base_class_namespace . '\\' . basename($filename,".php");
                        if (class_exists($classNamespace) || interface_exists($classNamespace)) {
                            $classList[] = $classNamespace;
                        }
                    }
                }
            }

            return $classList;
        };
        $classList = [];
        if ($only_target_class) {
            $classList[] = $target_namespace;
        } else {
            $classList = $find_class($base_class_namespace,$base_path,$suffix_preg,$sub_dir);
        }

        foreach ($classList as $class) {
            if (method_exists($class,'install')) {
                $custom_validator_func =  static::buildCustomValidator($class);
                static::$validators = array_merge(static::$validators,call_user_func($custom_validator_func));
            }
        }
    }
}
