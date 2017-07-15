<?php

require_once __DIR__ . '/../src/utility/CmdParser.php';

use PHPUnit\Framework\TestCase;
use ZKit\console\utility\CmdParser;
define('APP_DEBUG', true);

class CmdParserTest extends TestCase
{

    public function testParserRight()
    {
        $parser = new CmdParser;
        $rs = $parser->parse(array('app', '--dir', 'test', '--ww', 'dd'));
        $this->assertEquals(0, $rs);
        $this->assertEquals('test', $parser->requiredParam('dir'));
        $this->assertEquals(null, $parser->requiredParam('x'));
        $this->assertEquals('dd', $parser->requiredParam('ww'));
    }

    public function testParserErrorKey()
    {
        $parser = new CmdParser;
        $rs = $parser->parse(array('app', 'dir', 'test', '--ww', 'dd'));
        $this->assertEquals(0, $rs);
        $this->assertEquals(null, $parser->requiredParam('dir'));
        $this->assertEquals('dd', $parser->requiredParam('ww'));
    }

    public function testParserSpaicalValue()
    {
        $parser = new CmdParser;
        $rs = $parser->parse(array('app', '--dir', '--test', '--ww', 'dd'));
        $this->assertEquals(0, $rs);
        $this->assertEquals('--test', $parser->requiredParam('dir'));
        $this->assertEquals('dd', $parser->requiredParam('ww'));
    }

    public function testParserError()
    {
        $parser = new CmdParser;

        $rs = $parser->parse(array());
        $this->assertNotEquals(0, $rs);
    }

    public function testParserWithNoParam()
    {
        $parser = new CmdParser;
        $rs = $parser->parse(array('app'));
        $this->assertEquals(0, $rs);
        $this->assertEquals(null, $parser->requiredParam('app'));
        $this->assertEquals(null, $parser->requiredParam('dir'));
    }

}
