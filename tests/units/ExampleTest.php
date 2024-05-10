<?php
namespace hvalidation\tests\units;
use hvalidation\tests\TestCase;
use \hehe\core\hvalidation\Validation;

class ExampleTest extends TestCase
{

    /**
     * 默认验证器验证
     */
    public function testDefaultValidators() {

        // 必填验证器
        $this->assertTrue($this->hvalidation->required('admin'));
        $this->assertFalse($this->hvalidation->required(''));

        // 判断是否为空
        $this->assertTrue($this->hvalidation->empty(''));
        $this->assertTrue($this->hvalidation->empty(0));
        $this->assertFalse($this->hvalidation->empty('XXX'));

        // 是否为浮点数
        $this->assertTrue($this->hvalidation->float('1.0'));
        $this->assertTrue($this->hvalidation->float('1'));
        $this->assertTrue($this->hvalidation->float(1));
        $this->assertTrue($this->hvalidation->float(1.0));
        $this->assertFalse($this->hvalidation->float('a1'));

        // 是否整数
        $this->assertTrue($this->hvalidation->float(1.01,['decimalPoint'=>2]));
        $this->assertFalse($this->hvalidation->float(1.011,['decimalPoint'=>2]));
        $this->assertTrue($this->hvalidation->float(-1,['symbol'=>'-']));
        $this->assertFalse($this->hvalidation->float(-1,['symbol'=>'+']));

        // 是否布尔值
        $this->assertTrue($this->hvalidation->boolean(true));
        $this->assertTrue($this->hvalidation->boolean(false));
        $this->assertFalse($this->hvalidation->boolean(1));
        $this->assertFalse($this->hvalidation->boolean('ab'));
        $this->assertFalse($this->hvalidation->boolean('1.0'));


        // 是否为为整型
        $this->assertTrue($this->hvalidation->int(1));
        $this->assertTrue($this->hvalidation->int('1'));
        $this->assertTrue($this->hvalidation->int('0'));
        $this->assertFalse($this->hvalidation->int('1.0'));
        $this->assertFalse($this->hvalidation->int('1.00'));
        $this->assertTrue($this->hvalidation->int(-1,['symbol'=>'-']));
        $this->assertTrue($this->hvalidation->int(1,['symbol'=>'+']));

        // 验证11位手机号
        $this->assertTrue($this->hvalidation->tel('13511111111'));
        $this->assertFalse($this->hvalidation->tel('135fdde1111'));
        $this->assertFalse($this->hvalidation->tel('135111111112'));

        // 验证日期格式
        $this->assertTrue($this->hvalidation->date('2010-1-20'));
        $this->assertFalse($this->hvalidation->date('2010-20-20'));
        $this->assertTrue($this->hvalidation->date('2010-1-20 17:59:59',['format'=>'Y-m-d H:i:s']));

        // 验证日期范围
        $this->assertTrue($this->hvalidation->rangedate('2020-1-20 17:59:59',['min'=>'2019-10-10']));
        $this->assertTrue($this->hvalidation->rangedate('2018-1-20 17:59:59',['max'=>'2019-10-10']));
        $this->assertFalse($this->hvalidation->rangedate('2018-1-20 17:59:59',['min'=>'2019-10-10']));
        $this->assertFalse($this->hvalidation->rangedate('2023-1-20 17:59:59',['max'=>'2019-10-10']));

        $this->assertTrue($this->hvalidation->rangedate('2023-1-20 17:59:59',['min'=>'2018-10-10','max'=>'2023-10-10']));
        $this->assertFalse($this->hvalidation->rangedate('2024-1-20 17:59:59',['min'=>'2018-10-10','max'=>'2023-10-10']));
        $this->assertFalse($this->hvalidation->rangedate('2014-1-20 17:59:59',['min'=>'2018-10-10','max'=>'2023-10-10']));

        // 验证邮箱
        $this->assertTrue($this->hvalidation->email('hehe@163.com'));
        $this->assertFalse($this->hvalidation->email('hehe163.com'));


        // 验证上传文件
        $file = [
            'name'=>'Screen Shot 2016-05-12 at 18.13.24.png',
            'type'=>'image/png',
            'tmp_name'=>'/private/var/tmp/phplVHp3W',
            'error'=>0,
            'size'=>1024 * 1024 * 2,
        ];

        $this->assertTrue($this->hvalidation->file($file,['max_size'=>2]));
        $this->assertTrue($this->hvalidation->file($file,['max_size'=>3]));
        $this->assertFalse($this->hvalidation->file($file,['max_size'=>1,5]));

        $this->assertTrue($this->hvalidation->file($file,['exts'=>['jpg','gif','png']]));
        $this->assertFalse($this->hvalidation->file($file,['exts'=>['jpg','gif']]));

        $this->assertTrue($this->hvalidation->file($file,['mimes'=>['image/gif','image/png']]));
        $this->assertFalse($this->hvalidation->file($file,['mimes'=>['image/gif']]));

        // ip 验证
        $this->assertTrue($this->hvalidation->ip('127.0.0.1'));
        $this->assertFalse($this->hvalidation->ip('127.0.x.1'));
        $this->assertTrue($this->hvalidation->ip4('127.0.1.1'));
        $this->assertFalse($this->hvalidation->ip4('127.0.ab.1'));
        $this->assertTrue($this->hvalidation->ip6('2001:0db8:3c4d:0015:0000:0000:1a2f:1a2b'));
        $this->assertFalse($this->hvalidation->ip6('2001:0db81:3c4d:0015:0000:0000:1a2f:1a2b'));

        // url 地址验证
        $this->assertTrue($this->hvalidation->url('http://www.baidu.com'));
        $this->assertTrue($this->hvalidation->url('http://www.baidu.com/?id=1'));
        $this->assertTrue($this->hvalidation->url('http://www.baidu.com/id/2'));
        $this->assertTrue($this->hvalidation->url('http://www.baidu.com/id/2?name=hehe'));
        $this->assertFalse($this->hvalidation->url('http//www.baidu.com/?id=1'));

        $this->assertTrue($this->hvalidation->range(11,["min"=>10,'max'=>20]));
        $this->assertFalse($this->hvalidation->range(9,["min"=>10,'max'=>20]));
        $this->assertTrue($this->hvalidation->range(10,["min"=>10,'max'=>20]));
        $this->assertFalse($this->hvalidation->range(21,["min"=>10,'max'=>20]));
        $this->assertTrue($this->hvalidation->range(20,["min"=>10,'max'=>20]));
        $this->assertTrue($this->hvalidation->range(11,["min"=>10]));
        $this->assertTrue($this->hvalidation->range(10,["min"=>10]));
        $this->assertFalse($this->hvalidation->range(9,["min"=>10]));
        $this->assertTrue($this->hvalidation->range(15,["max"=>20]));
        $this->assertFalse($this->hvalidation->range(21,["max"=>20]));
        $this->assertTrue($this->hvalidation->range(20,["max"=>20]));

        // 比较数值大小验证器
        $this->assertTrue($this->hvalidation->compare(1,["number"=>1,'operator'=>'eq']));
        $this->assertTrue($this->hvalidation->compare('1',["number"=>1,'operator'=>'eq']));
        $this->assertFalse($this->hvalidation->compare('0',["number"=>1,'operator'=>'eq']));

        $this->assertTrue($this->hvalidation->compare(6,["number"=>5,'operator'=>'gt']));
        $this->assertFalse($this->hvalidation->compare(4,["number"=>5,'operator'=>'gt']));
        $this->assertFalse($this->hvalidation->compare(5,["number"=>5,'operator'=>'gt']));
        $this->assertTrue($this->hvalidation->compare(5,["number"=>5,'operator'=>'egt']));

        $this->assertTrue($this->hvalidation->compare(4,["number"=>5,'operator'=>'lt']));
        $this->assertFalse($this->hvalidation->compare(5,["number"=>5,'operator'=>'lt']));
        $this->assertFalse($this->hvalidation->compare(6,["number"=>5,'operator'=>'lt']));
        $this->assertTrue($this->hvalidation->compare(5,["number"=>5,'operator'=>'elt']));

        $this->assertFalse($this->hvalidation->compare('5g',["number"=>5,'operator'=>'elt']));

        // 验证字符串长度大小
        $this->assertTrue($this->hvalidation->minlen('aaaaabbbbb',["number"=>9]));
        $this->assertTrue($this->hvalidation->minlen('aaaaabbbb',["number"=>9]));
        $this->assertFalse($this->hvalidation->minlen('aaaaabbb',["number"=>9]));

        $this->assertTrue($this->hvalidation->maxlen('aaaaabbbb',["number"=>10]));
        $this->assertTrue($this->hvalidation->maxlen('aaaaabbbbb',["number"=>10]));
        $this->assertFalse($this->hvalidation->maxlen('aaaaabbbbbv',["number"=>10]));
        $this->assertTrue($this->hvalidation->eqlen('abcdef',["number"=>6]));
        $this->assertFalse($this->hvalidation->eqlen('abcdef1',["number"=>6]));

        // 验证字符串长度范围
        $this->assertTrue($this->hvalidation->rangelen("aaaaabbbbb3",["min"=>10,'max'=>20]));
        $this->assertFalse($this->hvalidation->rangelen("aaaaabbbb",["min"=>10,'max'=>20]));
        $this->assertTrue($this->hvalidation->rangelen("aaaaabbbbb",["min"=>10,'max'=>20]));
        $this->assertFalse($this->hvalidation->rangelen("aaaaabbbbbaaaaabbbbb3",["min"=>10,'max'=>20]));
        $this->assertTrue($this->hvalidation->rangelen("aaaaabbbbbaaaaabbbbb",["min"=>10,'max'=>20]));
        $this->assertTrue($this->hvalidation->rangelen("aaaaabbbbb3",["min"=>10]));
        $this->assertTrue($this->hvalidation->rangelen("aaaaabbbbb",["min"=>10]));
        $this->assertFalse($this->hvalidation->rangelen("aaaaabbbb",["min"=>10]));
        $this->assertTrue($this->hvalidation->rangelen("aaaaabbbbbaaaaa",["max"=>20]));
        $this->assertFalse($this->hvalidation->rangelen("aaaaabbbbbaaaaabbbbb1",["max"=>20]));
        $this->assertTrue($this->hvalidation->rangelen("aaaaabbbbbaaaaabbbbb",["max"=>20]));

        // 验证货币
        $this->assertTrue($this->hvalidation->currency(5.01,["decimalPoint"=>2]));
        $this->assertTrue($this->hvalidation->currency(5,["decimalPoint"=>2]));
        $this->assertTrue($this->hvalidation->currency(5.1,["decimalPoint"=>2]));
        $this->assertFalse($this->hvalidation->currency(5.101,["decimalPoint"=>2]));
        $this->assertFalse($this->hvalidation->currency('5.01a'));
        $this->assertTrue($this->hvalidation->currency(5));
        $this->assertTrue($this->hvalidation->currency(5.1));
        $this->assertFalse($this->hvalidation->currency(5.101));


        $this->assertTrue($this->hvalidation->cn("爱我中国"));
        $this->assertFalse($this->hvalidation->cn("爱我hehe"));
        $this->assertFalse($this->hvalidation->cn("hehe"));
        $this->assertFalse($this->hvalidation->cn(1.20));

        // 验证英文
        $this->assertTrue($this->hvalidation->en("are you ok"));
        $this->assertTrue($this->hvalidation->en("you"));
        $this->assertFalse($this->hvalidation->en("yoy 6668"));
        $this->assertFalse($this->hvalidation->en("yoy 我"));
        $this->assertFalse($this->hvalidation->en("天收你"));
        $this->assertFalse($this->hvalidation->en("10"));

        // 验证字母字符下划线格式
        $this->assertTrue($this->hvalidation->alpha("admin"));
        $this->assertFalse($this->hvalidation->alpha("admin1"));

        // 验证字母、数字格式
        $this->assertTrue($this->hvalidation->alphaNum("admin"));
        $this->assertTrue($this->hvalidation->alphaNum("admin123"));
        $this->assertFalse($this->hvalidation->alphaNum("admin123!"));

        // 字母、数字、破折号（ - ）以及下划线（ _ ）格式
        $this->assertTrue($this->hvalidation->alphaDash("admin"));
        $this->assertTrue($this->hvalidation->alphaDash("admin123"));
        $this->assertTrue($this->hvalidation->alphaDash("admin_123"));
        $this->assertFalse($this->hvalidation->alphaDash("admin_123$"));

        // 验证必须包含在指定列表
        $this->assertTrue($this->hvalidation->inlist(1,['numbers'=>[1,2,3]]));
        $this->assertFalse($this->hvalidation->inlist(4,['numbers'=>[1,2,3]]));
        $this->assertTrue($this->hvalidation->inlist('b',['numbers'=>['a','b','c']]));
        $this->assertFalse($this->hvalidation->inlist('d',['numbers'=>['a','b','c']]));

        $this->assertTrue($this->hvalidation->enum(1,['numbers'=>[1,2,3]]));
        $this->assertFalse($this->hvalidation->enum(4,['numbers'=>[1,2,3]]));
        $this->assertTrue($this->hvalidation->enum('b',['numbers'=>['a','b','c']]));
        $this->assertFalse($this->hvalidation->enum('d',['numbers'=>['a','b','c']]));

        $this->assertTrue($this->hvalidation->notin('d',['numbers'=>['a','b','c']]));
        $this->assertFalse($this->hvalidation->notin('b',['numbers'=>['a','b','c']]));

        // 验证身份证
        $this->assertTrue($this->hvalidation->card('410184123345668319'));
        $this->assertTrue($this->hvalidation->card('41018412334566831X'));
        $this->assertFalse($this->hvalidation->card('4101841233456683191'));

        // ids
        $this->assertTrue($this->hvalidation->ids(1));
        $this->assertFalse($this->hvalidation->ids(1.1));
        $this->assertTrue($this->hvalidation->ids('1,2,5'));
        $this->assertFalse($this->hvalidation->ids('1,2,a'));

        // 给列表里的每个元素指定验证器
        $this->assertTrue($this->hvalidation->vlist([3,4,8],['validators'=>[ ['int'],['range','min'=>1,'max'=>10,] ]]));
        $this->assertFalse($this->hvalidation->vlist([3,4,8],['validators'=>[ ['int'],['range','min'=>4,'max'=>10,] ]]));

        // 正则表达验证
        $this->assertTrue($this->hvalidation->reg(1,['pattern'=>'/^-?\d+$/']));
        $this->assertTrue($this->hvalidation->reg(1.0,['pattern'=>'/^-?\d+$/']));
        $this->assertFalse($this->hvalidation->reg('ab',['pattern'=>'/^-?\d+$/']));

        $this->assertTrue($this->hvalidation->post('111111'));
        $this->assertFalse($this->hvalidation->post('11111A'));

    }


}
