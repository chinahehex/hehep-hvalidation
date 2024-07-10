# hehep-hvalidation

## 介绍
- hehep-hvalidation 是一个PHP 验证器工具组件
- 支持多个验证器
- 支持验证多个属性
- 支持验证多维数组
- 直接使用验证器验证
- 支持与或 or,and,&,| 运算
- 支持单独设置验证规则错误消息
- 支持验证规则使用场景
- 支持设置验证规则的前置条件
- 支持添加自定义验证器
- 支持验证器直接为方法或函数
- 支持自定义错误码

## 安装
- **gitee下载**:
```
git clone git@gitee.com:chinahehex/hehep-hvalidation.git
```

- **github下载**:
```
git clone git@github.com:chinahehex/hehep-hvalidation.git
```

- 命令安装：
```
composer require hehex/hehep-hvalidation
```

## 组件配置
```
验证规则:
['验证名称',[['验证器1','验证器1属性1'=>'','验证器1属性2'=>''],['验证器2','验证器2属性1'=>'','验证器2属性2'=>''] ],'验证规则属性1'=>'','验证规则属性2'=>''],
```

```php

// 验证器参数
$validatorConf= [
    "message"=>"你输入的格式错误!",// 错误消息,
    "err_code"=>null,// 错误码,非必填
    "skipOnEmpty"=>true,// 当验证值为空时是否调用验证,true 表示值为空时不验证,false 表示值为空时继续验证
];

// 验证规则参数
$ruleConf = [
    "goon"=>false,// 当验证失败后,是否继续其他验证
    "message"=>"你输入的格式错误!",// 错误消息
    "err_code"=>null,// 错误码,非必填
    "on"=>"create",// 使用场景
    "when"=>'valint(方法或函数)',// 满足条件,规则才有效
];
```
## 基本示例

- 快速使用
```php
use hehe\core\hvalidation\Validation;
$hvalidation = new Validation();

// 校验数据
$data = [
    'name'=>"hehe",// 用户姓名
    'age'=>2,// 年龄
    'userType'=>1,// 用户类型
    'tel'=>'138xxxxxxxxx',// 联系方式
];

// 校验规则
$rules = [
    ['name',[['required']],'message'=>'很多的'],
    ['age',[['required'],['number','message'=>'年龄必须为数字','err_code'=>-1]],'message'=>'请输入的年龄格式错误!','err_code'=>-2],
    ['userType',[['required'],['inlist','numbers'=>[1,2,3,4]]],'message'=>'用户类型的值必须为1,2,3,4!'],
    ['tel',['or',['phone'],['mobile']],'message'=>'请输入手机号或固定电话'],
    
];

$validationResult = $hvalidation->validate($rules,$data);
if (!$validationResult->getResult()) {
    var_dump("校验失败");
    // 获取首个验证器错误消息
    var_dump($validationResult->getFirstError());
    var_dump($validationResult->getFirstCode());
} else {
    var_dump("校验成功");
}

// 验证是否手机
Validation::tel('135xxxxxxx');

// 验证是否ip
Validation::ip('135xxxxxxx');

```

- 多个验证器,支持与或(or,and,&,|)
```php
$rules = [
    ['attr1',[['required'],['minlen','min'=>10,'max'=>20]],'message'=>'请输入一个10-20位的字符串'],
    ['attr1',['or',['boolean'],['minlen','min'=>10,'max'=>20]],'message'=>'请输入一个10-20位的字符串或布尔型'],
]

$rules = [
    ['attr1',['&' [['验证器1']],['or',[['验证器2']],[['验证器3']]] ],'message'=>'多验证器,或'],
]

```

- 验证多个属性(不建议这么用)
```php
$rules = [
    ['attr1,attr2',[['!empty']],'message'=>'参数不能为空'],
]
```

- 验证多维数组
```php
//@todo
```

- 设置验证规则错误消息
```php
$rules = [
    ['attr1',[['required'],['minlen','min'=>10,'max'=>20]],'message'=>'请输入一个10-20位的字符串']
]
```

- 设置验证器错误消息
```php
$rules = [
    ['attr1',[['required'],['minlen','min'=>10,'max'=>20,'message'=>'请输入一个10-20位的字符串']],'message'=>'不能为空']
]
```

- 设置验证规则使用场景
```php
// on=add 用于添加规则
$rules = [
    ['attr1',[['required'],['minlen','min'=>10,'max'=>20]],'message'=>'请输入一个10-20位的字符串','on'=>'add']
]
```

- 设置验证规则的前置条件
```php
/**
 * @param $rule 当前规则对象
 * @param $attrs 传入的所有数据
 */
function whencon($rule,$attrs) {
    return true;
}

$rules = [
    ['attr1',[['required'],['minlen','min'=>10,'max'=>20]],'message'=>'请输入一个10-20位的字符串','when'=>'whencon']
];

$rules = [
    ['attr1',[['required'],['minlen','min'=>10,'max'=>20]],'message'=>'请输入一个10-20位的字符串','when'=>[$this,'wwhen']]
];

```

- 添加自定义验证器
```php
use hehe\core\hvalidation\Validation;
$hvalidation = new Validation();
$validation->addValidateType('自定义验证器别名','hehe\\core\\validate\\BooleanValidate','自定义消息内容');
```

- 验证器直接为方法或函数
```php
$rules = [
     ['attr1',[ [[$this,'func1'] ] ],'message'=>'请输入一个10-20位的字符串']
];
```

- 验证器直接为闭包
```php
$rules = [
     ['attr1',[ [function($val,CallValidator $validator){
        // 验证结果 true or false
        
        // 定义的其他参数
        $validator->params;
        
     } ] ],'message'=>'请输入一个10-20位的字符串']
];
```

- 直接使用验证器验证
```php
use hehe\core\hvalidation\Validation;
$result = Validation::number('12',['name'=>23232]);
// result : true or false
```

- 直接实例化验证类，调用验证类方法
```php
use hehe\core\hvalidation\Validation;
$validation = new Validation();
$validate = $validation->createValidator('range',['min'=>10,'max'=>20]);
$result = $validate->validate(20);
// result : true or false
```

- 注解注册验证规则
```php
use hehe\core\hvalidation\annotation\RequiredValid;
use hehe\core\hvalidation\annotation\RangeLengthValid;
use hehe\core\hvalidation\annotation\EgtValid;

class IndexController
{
    /**
     * @var string
     * @RequiredValid("不能为空")
     * @RangeLengthValid(min=10,max=20)
     */
     public $name;
    
    /**
     * @var string
     * @RequiredValid("不能为空")
     * @EgtValid(number=10)
     */
     public $age;

}

```

## 扩展验证器

- 操作步骤如下

**步骤1。创建自定义验证器集合类**
```php
/**
 * 自定义验证器
 * Class CommonValidators
 * @package common\extend\validators
 */
class CommonValidators
{
    // 定义
    public static function install()
    {
        return [
            'tel'=>['class'=>'common\extend\validators\TelValidators'],
            // 静态方法调用
            'ip'=>['class'=>'CallValidator','func'=>'common\extend\validators\CommonValidators@@ip'],
            // 对象方法调用
            'ip6'=>['class'=>'CallValidator','func'=>'common\extend\validators\CommonValidators@ip6'],
            //'ip'=>['class'=>'CallValidator','func'=>[static::class,'ip']],
        ];
    }

    public static function ip($value)
    {

        $valid = preg_match('/^(\d+\.\d+\.\d+\.\d+)$/', $value);

        return $valid === 1;
    }

    public function ip6($value)
    {

        $valid = preg_match('/^(\d+\.\d+\.\d+\.\d+)$/', $value);

        return $valid === 1;
    }
}
```

**步骤2。创建手机号码验证器类**
```php
namespace common\extend\validators;
use hehe\core\hvalidation\base\Validator;

class TelValidator extends Validator
{
    public static function install()
    {
        return [
            'tel'=>['class'=>static::class,'其他规则'=>'xxxx'],
        ];
    }
    
    protected $pattern = '/^1[0-9]{10}$/';

    protected function validateValue($value,$name = null)
    {
        $valid = preg_match($this->pattern, $value);

        return $valid === 1;
    }
}
```

**步骤3。验证器类组件配置**
```php
// 创建Validation 对象后,自动加载CommonValidators 类定义的验证规则
$hvalidation = new Validation([
        'customValidators'=>[
            'common\extend\validators\CommonValidators',// 需安装的验证器集合类
            [dirname(__FILE__),'\common\extend\validators'] // ['安装的目录','目录对应的命名空间']
        ]
]);

// 安装的方式
Validation::install('common\extend\validators\CommonValidators');

```

## 安装验证器
- **指定验证器安装**
```php
Validation::install('common\extend\validators\CommonValidators');

```

- **指定验证器类同目录下所有验证器安装**
```php
Validation::install('common\extend\validators\CommonValidators',true);

```

- **指定验证器类同级目录以及其子目录下所有验证器**
```php
Validation::install('common\extend\validators\CommonValidators',true,true);

```

- **安装指定后缀的验证器(默认前缀validator)**
```php
Validation::install('common\extend\validators\CommonValidators',true,false,'validators');

```

- **指定目录安装(目录下所有验证器都会安装)**
```php
// 目录下所有验证器都会被安装
Validation::install([
    dirname(__FILE__),// 安装的目录
    '\common\extend\validators',目录对应的命名空间
]);

```

## 注解验证
- 定义被验证类
```php
namespace hvalidation\tests\common;
use hehe\core\hvalidation\annotation\RequiredValid;
use hehe\core\hvalidation\annotation\NumberValid;
use hehe\core\hvalidation\annotation\InlistValid;
use hehe\core\hvalidation\annotation\Validator;
use hehe\core\hvalidation\annotation\MobileValid;

class UserController
{
    /**
     * @RequiredValid("姓名不能为空")
     * @var string
     */
    public $name;

    /**
     * @RequiredValid("请填写年龄")
     * @NumberValid("请输入的年龄格式错误")
     * @var string
     */
    public $age;

    /**
     * @RequiredValid("请选择用户类型")
     * @InlistValid("用户类型的值必须为1,2,3,4!",numbers="1,2,3,4")
     * @var string
     */
    public $userType;

    /**
     * @MobileValid("手机号码",numbers="1,2,3,4")
     * @var string
     */
    public $tel;

    /**
     * @RequiredValid(message="姓名不能为空",name="name")
     * @RequiredValid("姓名不能为空",name="age")
     * @NumberValid("请输入的年龄格式错误",name="age")
     * @RequiredValid("请选择用户类型",name="userType")
     * @InlistValid("用户类型的值必须为1,2,3,4!",name="userType",numbers={1,2,3,4})
     * @Validator("手机号码",name="tel",validator={"or",{"mobile"},{"phone"}})
     */
    public function add(){}

    /**
     * @RequiredValid("姓名不能为空",name="name")
     * @RequiredValid("姓名不能为空",name="age")
     * @NumberValid("请输入的年龄格式错误",name="age")
     * @RequiredValid("请选择用户类型",name="userType")
     */
    #[InlistValid(message:"用户类型的值必须为1,2,3,4!",name:"userType",numbers:"1,2,3,4")]
    #[Validator("联系电话错误",name:"tel",validator:array('or',array('mobile'),array('phone')))]
    public function add1(){}
}
```

- 验证示例
```php
use hehe\core\hvalidation\Validation;
 // 验证数据
$data = [
    'name'=>"hehe",// 用户姓名
    'age'=>2,// 年龄
    'userType'=>4,// 用户类型
    'tel'=>'13811111111',// 联系方式
];


$hvalidation = new Validation();
// 获取UserController 类属性的验证规则
$rules = Validation::getRule(UserController::class);
$rules = $hvalidation->getClassRule(UserController::class);

// 获取UserController类add方法的验证规则
$rules = $hvalidation->getMethodRule(UserController::class,'add');
$rules = Validation::getRule(UserController::class . '@add');


$validationResult = $hvalidation->validate($rules,$data);

```



## 默认验证器
验证器 | 说明 | 规则示例
----------|-------------|------------
`required`  | 必填字段 | `['fieldname', ['required'] ]`
`empty`  | 不为空字段,常配合!使用 | `['fieldname', ['empty'] ]`，`['fieldname', ['!empty'] ]`
`float`  | 数值必须为浮点数,即整型,或带小数点的数值 | `['fieldname', ['float','decimalPoint'=>'最少保留的小数点位数,如2','symbol'=>'正负符号,如-,+'] ]`
`int`  | 数值必须为整型 | `['fieldname', ['int','symbol'=>'正负符号,如-,+'] ]`
`boolean`  | 数值必须为布尔值,True or False | `['fieldname', ['boolean'] ]`
`tel`  | 11 位手机号 | `['fieldname', ['tel'] ]`
`date`  | 验证日期格式 | `['fieldname', ['date',["format":'Y-m-d']] ]`
`rangedate`  | 验证日期范围 | `['fieldname', ['rangedate',"min"=>'最小日期,如2019-10-10','max'=>'最大日期,如2010-10-11'] ]`
`email`  | 验证邮箱格式 | `['fieldname', ['email'] ]`
`file`  | 验证表单file格式 | `['fieldname', ['file','max_size'=>0.5,'exts'=>['jpg','gif','png'],'mimes'=>['image/gif']] ]`
`ip`  | 验证ip格式,支持mode 格式 ip4,ip6 | `['fieldname', ['ip',"mode"=>"ip4"]`
`ip4`  | 验证ip4格式 | `['fieldname', ['ip4']]`
`ip6`  | 验证ip6格式 | `['fieldname', ['ip6']]`
`url`  | 验证url 地址格式,支持设置defaultScheme | `['fieldname', ['url',"defaultScheme"=>"https"]]`
`range`  | 验证数值范围大小 | `['fieldname', ['range',"min"=>10,'max'=>20] ]`
`compare`  | 比较指定数值大小,支持操作符,'gt','egt','lt','elt','eq','>','>=','<','<=','=' | `['fieldname', ['compare',"number"=>10,"operator"=>"gt"] ]`
`eq`  | 验证数值相等,compare 操作符 eq 的简写  | `['fieldname', ['eq',"number"=>1]]`
`gt`  | 验证数值大于,compare 操作符 gt 的简写  | `['fieldname', ['gt',"number"=>1]]`
`egt`  | 验证数值大于等于,compare 操作符 egt 的简写  | `['fieldname', ['egt',"number"=>1]]`
`lt`  | 验证数值小于,compare 操作符 lt 的简写  | `['fieldname', ['lt',"number"=>1]]`
`elt`  | 验证数值小于等于,compare 操作符 elt 的简写  | `['fieldname', ['elt',"number"=>1]]`
`minlen`  | 验证字符最小长度  | `['fieldname', ['minlen',"number"=>1]]`
`maxlen`  | 验证字符最大长度  | `['fieldname', ['maxlen',"number"=>1]]`
`eqlen`  | 验证字符固定长度  | `['fieldname', ['eqlen',"number"=>1]]`
`rangelen`  | 验证字符长度范围  | `['fieldname', ['rangelen',"min"=>1,'max'=>3]]`
`currency`  | 验证货币数值,比如0.51,decimalPoint 表示最多几位小数，默认最多2位  | `['fieldname', ['currency',"decimalPoint"=>2]]`
`cn`  | 验证中文格式 | `['fieldname', ['ch']]`
`en`  | 验证英文格式 | `['fieldname', ['en']]`
`card`  | 验证身份证格式 | `['fieldname', ['card']]`
`alpha`  | 验证包含字母字符格式 | `['fieldname', ['alpha']]`
`alphaNum`  | 验证包含字母、数字格式 | `['fieldname', ['alphaNum']]`
`alphaDash`  | 验证字母、数字、破折号（ - ）以及下划线（ _ ）格式 | `['fieldname', ['alphaDash']]`
`inlist`  | 输入的值或值集合必须包含在指定的列表 | `['fieldname', ['inlist',['numbers'=>['1','2','3']]]]`
`enum`  | 输入的值必须包含在指定的列表 | `['fieldname', ['enum',['numbers'=>['1','2','3']]]]`
`notin`  | 输入的值必须不包含在指定的列表 | `['fieldname', ['notin']]`
`vlist`  | 给列表里的每个元素指定验证器 | `['fieldname', ['vlist',[ ['int'],['minlen'] ]]]`
`ids`  | 验证id值是否为整型 | `['fieldname', ['ids']]`
`eqstrfield`  | 验证字段与指定字段值是否相等 | `['fieldname', ['eqstrfield',"field"=>"confirmpassword"]]]]`
`eqintfield`  | 验证字段与指定字段数值是否相等 | `['fieldname', ['eqintfield',"field"=>"age"]]]`
`gtintfield`  | 验证字段与指定字段数值是否大于 | `['fieldname', ['gtintfield',"field"=>"age"]]`
`egtintfield`  | 验证字段与指定字段数值是否大于等于 | `['fieldname', ['egtintfield',"field"=>"age"]]`
`ltintfield`  | 验证字段与指定字段数值是否小于 | `['fieldname', ['ltintfield',"field"=>"age"]]`
`eltintfield`  | 验证字段与指定字段数值是否小于等于 | `['fieldname', ['eltintfield',"field"=>"age"]]`
`gtdatefield`  | 验证日期字段与指定日期字段数值是否大于 | `['enddate', ['gtdatefield',"field"=>"startdate"]]`
`egtdatefield`  | 验证日期字段与指定日期字段数值是否大于等于 | `['enddate', ['egtdatefield',"field"=>"startdate"]]]`
`ltdatefield`  | 验证日期字段与指定日期字段数值是否小于 | `['enddate', ['ltdatefield',"field"=>"startdate"]]`
`eltdatefield`  | 验证日期字段与指定日期字段数值是否小于等于 | `['enddate', ['eltdatefield',"field"=>"startdate"]]`
