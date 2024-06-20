<?php
namespace hvalidation\tests\common;
use hehe\core\hvalidation\annotation\RequiredValid;
use hehe\core\hvalidation\annotation\NumberValid;
use hehe\core\hvalidation\annotation\InlistValid;
use hehe\core\hvalidation\annotation\Validator;
use hehe\core\hvalidation\annotation\MobileValid;
use hvalidation\tests\common\Ok;

class User
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
     * @InlistValid("用户类型的值必须为1,2,3,4!",numbers={1,2,3,4})
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
    public function add()
    {

    }

    /**
     * @RequiredValid("姓名不能为空",name="name")
     * @RequiredValid("姓名不能为空",name="age")
     * @NumberValid("请输入的年龄格式错误",name="age")
     * @RequiredValid("请选择用户类型",name="userType")
     */
    #[InlistValid("用户类型的值必须为1,2,3,4!",name:"userType",numbers:"1,2,3,4")]
    #[Validator("联系电话错误",name:"tel",validator:array('or',array('mobile'),array('phone')))]
    public function add1()
    {

    }
}
