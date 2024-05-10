<?php
namespace hvalidation\tests\units;
use hvalidation\tests\TestCase;


class RuleTest extends TestCase
{

    // 验证基本规则
    public function testValidRule()
    {
        // 验证数据
        $data = [
            'name'=>"hehe",// 用户姓名
            'age'=>2,// 年龄
            'userType'=>1,// 用户类型
            'tel'=>'13811111111',// 联系方式
        ];

        // 校验规则
        $rules = [
            ['name',[['required']],'message'=>'很多的'],
            ['age',[['required'],['number']],'message'=>'请输入的年龄格式错误!'],
            ['userType',[['required'],['inlist','numbers'=>[1,2,3,4]]],'message'=>'用户类型的值必须为1,2,3,4!'],
            ['tel',['or',['phone'],['mobile']],'message'=>'请输入手机号或固定电话'],
        ];

        $validationResult = $this->hvalidation->validate($rules,$data);

        $this->assertTrue($validationResult->getResult());
    }

    // 多个验证器,支持与或(or,and,&,|)
    public function testMoreValid()
    {

        $this->assertTrue($this->hvalidation->validate(
            [['userType',['and',['int'],['inlist','numbers'=>[1,2,3,4]]],'message'=>'用户类型的值必须为{numbers}!'],],
            ['userType'=>1,])->getResult());

        $this->assertTrue($this->hvalidation->validate(
            [['userType',['&',['int'],['inlist','numbers'=>[1,2,3,4]]],'message'=>'用户类型的值必须为{numbers}!'],],
            ['userType'=>1,])->getResult());

        $this->assertTrue($this->hvalidation->validate(
            [['userType',['or',['int'],['en']],'message'=>'请输入整型或英文'],],
            ['userType'=>1,])->getResult());

        $this->assertTrue($this->hvalidation->validate(
            [['userType',['|',['int'],['en']],'message'=>'请输入整型或英文'],],
            ['userType'=>1,])->getResult());

        $this->assertTrue($this->hvalidation->validate(
            [['userType',['or',['int'],['en']],'message'=>'请输入整型或英文'],],
            ['userType'=>"hehe",])->getResult());

        $this->assertFalse($this->hvalidation->validate(
            [['userType',['or',['int'],['en']],'message'=>'请输入整型或英文'],],
            ['userType'=>"爱我中国",])->getResult());

    }

    // 验证基本规则-自定义验证器消息
    public function testValidRuleMessage()
    {

        $this->assertEquals('手机号号码格式错误',$this->hvalidation->validate(
            [['tel',[['mobile','message'=>'手机号号码格式错误']],'message'=>'请输入错误提示消息'],],
            ['tel'=>"13511111111a",])->getFirstMessage());

        $this->assertEquals('请输入错误提示消息',$this->hvalidation->validate(
            [['tel',[['mobile']],'message'=>'请输入错误提示消息'],],
            ['tel'=>"13511111111a",])->getFirstMessage());
    }

    // 验证基本规则-状态码
    public function testValidRuleErrCode()
    {

        $this->assertEquals('1001',$this->hvalidation->validate(
            [['tel',[['mobile','message'=>'手机号号码格式错误','err_code'=>1001]],'message'=>'请输入错误提示消息'],],
            ['tel'=>"13511111111a",])->getFirstCode());

        $this->assertEquals('1002',$this->hvalidation->validate(
            [['tel',[['mobile']],'message'=>'请输入错误提示消息','err_code'=>1002],],
            ['tel'=>"13511111111a",])->getFirstCode());
    }

    // 验证基本规则-使用场景
    public function testValidRuleOn()
    {
        $rules = [
            ['id',[['required'],['ids']],'message'=>'请输入合法的id','on'=>'edit'],
            ['realName',[['required'],['rangelen','min'=>2,'max'=>6]],'message'=>'姓名必填'],
            ['age',[['int']],'message'=>'年龄格式错误'],
        ];

        $this->assertTrue($this->hvalidation->validate($rules,[
            'realName'=>'hehe',
            'age'=>1
        ],['add'])->getResult());

        $this->assertTrue($this->hvalidation->validate($rules,[
            'id'=>1,
            'realName'=>'hehe',
            'age'=>1
        ],['edit'])->getResult());

        $this->assertFalse($this->hvalidation->validate($rules,[
            'realName'=>'hehe',
            'age'=>1
        ],['edit'])->getResult());
    }

    // 验证基本规则-验证多个属性
    public function testValidRuleAttrs()
    {
        $rules = [
            ['id,age',[['required'],['ids']],'message'=>'请输入合法的id'],
        ];

        $this->assertTrue($this->hvalidation->validate($rules,[
            'id'=>'1',
            'age'=>1
        ])->getResult());

        $this->assertFalse($this->hvalidation->validate($rules,[
            'id'=>'1a',
            'age'=>1
        ])->getResult());

    }

    public function testValidRuleWhen()
    {
        $rules = [
            ['id',[['required'],['ids']],'message'=>'请输入合法的id','when'=>[$this,'validRuleWhen']],
            ['age',[['int']],'message'=>'年龄格式错误'],
        ];

        $this->assertTrue($this->hvalidation->validate($rules,[
            'id'=>'1',
            'age'=>4
        ])->getResult());

        $this->assertTrue($this->hvalidation->validate($rules,[
            'id'=>'1a',
            'age'=>1
        ])->getResult());

        $this->assertFalse($this->hvalidation->validate($rules,[
            'id'=>'1a',
            'age'=>4
        ])->getResult());
    }

    public function validRuleWhen($rule,$attrs)
    {
        if (isset($attrs['age']) && $attrs['age'] > 3) {
            // 大于三岁才验证id
            return true;
        } else {
            return false;
        }
    }


    // 直接使用验证器验证
    public function testUseValidator()
    {
        // 创建一个数值范围验证器
        $validate = $this->hvalidation->createValidator('range',['min'=>10,'max'=>20]);

        $this->assertTrue($validate->validate(11));
        $this->assertTrue($validate->validate(10));
        $this->assertFalse($validate->validate(9));
        $this->assertTrue($validate->validate(20));
        $this->assertFalse($validate->validate(21));
    }

    // 使用闭包验证器
    public function testUseClosureValidator()
    {
        $age_func = function($age) {
            if (is_int($age) && ($age >= 1 && $age <=150)) {
                return true;
            } else {
                return false;
            }
        };

        $rules = [
            ['id',[['required'],['ids']],'message'=>'请输入合法的id'],
            ['age',[[$age_func]],'message'=>'年龄格式错误'],
        ];

        $this->assertTrue($this->hvalidation->validate($rules,[
            'id'=>'1',
            'age'=>1
        ])->getResult());
    }

    // 使用闭包验证器
    public function testValidField()
    {

        $this->assertTrue($this->hvalidation->validate([
            ['confirmpwd',[['required'],['eqstrfield','field'=>'pwd']],'message'=>'确认密码必须与密码一致'],
        ],[
            'pwd'=>"123456",// 密码
            'confirmpwd'=>"123456",// 确认密码
        ])->getResult());

        $this->assertFalse($this->hvalidation->validate([
            ['confirmpwd',[['required'],['eqstrfield','field'=>'pwd']],'message'=>'确认密码必须与密码一致'],
        ],[
            'pwd'=>"123456",// 密码
            'confirmpwd'=>"1234567",// 确认密码
        ])->getResult());

        $this->assertTrue($this->hvalidation->validate([
            ['field2',[['required'],['eqintfield','field'=>'field1']],'message'=>'确认密码必须与密码一致'],
        ],[
            'field1'=>"100",
            'field2'=>"100",
        ])->getResult());

        $this->assertFalse($this->hvalidation->validate([
            ['field2',[['required'],['eqintfield','field'=>'field1']],'message'=>'验证字段与指定字段数值必须相等'],
        ],[
            'field1'=>"100",
            'field2'=>"101",
        ])->getResult());

        $this->assertTrue($this->hvalidation->validate([
            ['field1',[['required'],['gtintfield','field'=>'field2']],'message'=>'验证字段与指定字段数值是否大于'],
        ],[
            'field1'=>"102",
            'field2'=>"101",
        ])->getResult());

        $this->assertFalse($this->hvalidation->validate([
            ['field1',[['required'],['gtintfield','field'=>'field2']],'message'=>'验证字段与指定字段数值是否大于'],
        ],[
            'field1'=>"101",
            'field2'=>"102",
        ])->getResult());

        $this->assertTrue($this->hvalidation->validate([
            ['field1',[['required'],['egtintfield','field'=>'field2']],'message'=>'验证字段与指定字段数值是否大于'],
        ],[
            'field1'=>"102",
            'field2'=>"101",
        ])->getResult());

        $this->assertTrue($this->hvalidation->validate([
            ['field1',[['required'],['egtintfield','field'=>'field2']],'message'=>'验证字段与指定字段数值是否大于'],
        ],[
            'field1'=>"101",
            'field2'=>"101",
        ])->getResult());

        $this->assertTrue($this->hvalidation->validate([
            ['field1',[['required'],['ltintfield','field'=>'field2']],'message'=>'验证字段与指定字段数值是否大于'],
        ],[
            'field1'=>"100",
            'field2'=>"101",
        ])->getResult());

        $this->assertFalse($this->hvalidation->validate([
            ['field1',[['required'],['ltintfield','field'=>'field2']],'message'=>'验证字段与指定字段数值是否大于'],
        ],[
            'field1'=>"102",
            'field2'=>"101",
        ])->getResult());

        $this->assertTrue($this->hvalidation->validate([
            ['field1',[['required'],['eltintfield','field'=>'field2']],'message'=>'验证字段与指定字段数值是否大于'],
        ],[
            'field1'=>"100",
            'field2'=>"101",
        ])->getResult());

        $this->assertTrue($this->hvalidation->validate([
            ['date1',[['required'],['gtdatefield','field'=>'date2']],'message'=>'验证日期字段与指定日期字段数值是否大于'],
        ],[
            'date1'=>"2021-11-21",
            'date2'=>"2021-11-20",
        ])->getResult());

        $this->assertFalse($this->hvalidation->validate([
            ['date1',[['required'],['gtdatefield','field'=>'date2']],'message'=>'验证日期字段与指定日期字段数值是否大于'],
        ],[
            'date1'=>"2021-11-21",
            'date2'=>"2021-11-21",
        ])->getResult());

        $this->assertFalse($this->hvalidation->validate([
            ['date1',[['required'],['gtdatefield','field'=>'date2']],'message'=>'验证日期字段与指定日期字段数值是否大于'],
        ],[
            'date1'=>"2021-11-19",
            'date2'=>"2021-11-20",
        ])->getResult());

        $this->assertTrue($this->hvalidation->validate([
            ['date1',[['required'],['egtdatefield','field'=>'date2']],'message'=>'验证日期字段与指定日期字段数值是否大于'],
        ],[
            'date1'=>"2021-11-21",
            'date2'=>"2021-11-21",
        ])->getResult());

        $this->assertTrue($this->hvalidation->validate([
            ['date1',[['required'],['ltdatefield','field'=>'date2']],'message'=>'验证日期字段与指定日期字段数值是否大于'],
        ],[
            'date1'=>"2021-11-20",
            'date2'=>"2021-11-21",
        ])->getResult());

        $this->assertTrue($this->hvalidation->validate([
            ['date1',[['required'],['eltdatefield','field'=>'date2']],'message'=>'验证日期字段与指定日期字段数值是否大于'],
        ],[
            'date1'=>"2021-11-20",
            'date2'=>"2021-11-20",
        ])->getResult());

        $this->assertTrue($this->hvalidation->validate([
            ['date1',[['required'],['eltdatefield','field'=>'date2']],'message'=>'验证日期字段与指定日期字段数值是否大于'],
        ],[
            'date1'=>"2021-11-20",
            'date2'=>"2021-11-21",
        ])->getResult());

        $this->assertFalse($this->hvalidation->validate([
            ['date1',[['required'],['eltdatefield','field'=>'date2']],'message'=>'验证日期字段与指定日期字段数值是否大于'],
        ],[
            'date1'=>"2021-11-21",
            'date2'=>"2021-11-20",
        ])->getResult());



    }


}
