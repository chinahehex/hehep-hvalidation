<?php
namespace hvalidation\tests;
//require_once dirname(__DIR__) . '/vendor/autoload.php';

use \hehe\core\hvalidation\Validation;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \hehe\core\hvalidation\Validation
     */
    protected $hvalidation;

    protected function setUp():void
    {
        $this->hvalidation = new Validation();
    }
}
