<?php

/**
 * Nette Framework
 *
 * Copyright (c) 2004, 2009 David Grudl (http://davidgrudl.com)
 *
 * @category   Nette
 * @package    Nette
 * @subpackage UnitTests
 * @version    $Id$
 */

/*use Nette\Debug;*/
/*use Nette\String;*/



require_once 'PHPUnit/Framework.php';

require_once '../../Nette/loader.php';



/**
 * @package    Nette
 * @subpackage UnitTests
 */
class NetteStringTest extends PHPUnit_Framework_TestCase
{

	/**
	 * startsWith test.
	 * @return void
	 */
	public function testStartswith()
	{
		$this->assertTrue(String::startsWith('123', NULL), "String::startsWith('123', NULL)");
		$this->assertTrue(String::startsWith('123', ''), "String::startsWith('123', '')");
		$this->assertTrue(String::startsWith('123', '1'), "String::startsWith('123', '1')");
		$this->assertFalse(String::startsWith('123', '2'), "String::startsWith('123', '2')");
		$this->assertTrue(String::startsWith('123', '123'), "String::startsWith('123', '123')");
		$this->assertFalse(String::startsWith('123', '1234'), "String::startsWith('123', '1234')");
	}



	/**
	 * endsWith test.
	 * @return void
	 */
	public function testEndswith()
	{
		$this->assertTrue(String::endsWith('123', NULL), "String::endsWith('123', NULL)");
		$this->assertTrue(String::endsWith('123', ''), "String::endsWith('123', '')");
		$this->assertTrue(String::endsWith('123', '3'), "String::endsWith('123', '3')");
		$this->assertFalse(String::endsWith('123', '2'), "String::endsWith('123', '2')");
		$this->assertTrue(String::endsWith('123', '123'), "String::endsWith('123', '123')");
		$this->assertFalse(String::endsWith('123', '1234'), "String::endsWith('123', '1234')");
	}



	/**
	 * webalize test.
	 * @return void
	 */
	public function testWebalize()
	{
		$this->assertEquals("zlutoucky-kun-oooo", String::webalize('&ŽLUŤOUČKÝ KŮŇ öőôò!'));
		$this->assertEquals("1-4-!", String::webalize('¼!', '!'));
	}



	/**
	 * normalize test.
	 * @return void
	 */
	public function testNormalize()
	{
		$this->assertEquals("48656c6c6f0a2020576f726c64", bin2hex(String::normalize("\r\nHello  \r  World \n\n")));
	}



	/**
	 * checkEncoding test.
	 * @return void
	 */
	public function testCheckencoding()
	{
		$this->assertTrue(String::checkEncoding('žluťoučký'));
	}



	/**
	 * truncate test.
	 * @return void
	 */
	public function testTruncate()
	{
		iconv_set_encoding('internal_encoding', 'UTF-8');
		$s = 'Řekněte, jak se (dnes) máte?';

		$this->assertEquals("\xe2\x80\xa6", String::truncate($s, -1), "length=-1");
		$this->assertEquals("\xe2\x80\xa6", String::truncate($s, 0), "length=0");
		$this->assertEquals("\xe2\x80\xa6", String::truncate($s, 1), "length=1");
		$this->assertEquals("\xc5\x98\xe2\x80\xa6", String::truncate($s, 2), "length=2");
		$this->assertEquals("\xc5\x98e\xe2\x80\xa6", String::truncate($s, 3), "length=3");
		$this->assertEquals("\xc5\x98ek\xe2\x80\xa6", String::truncate($s, 4), "length=4");
		$this->assertEquals("\xc5\x98ekn\xe2\x80\xa6", String::truncate($s, 5), "length=5");
		$this->assertEquals("\xc5\x98ekn\xc4\x9b\xe2\x80\xa6", String::truncate($s, 6), "length=6");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bt\xe2\x80\xa6", String::truncate($s, 7), "length=7");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte\xe2\x80\xa6", String::truncate($s, 8), "length=8");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte,\xe2\x80\xa6", String::truncate($s, 9), "length=9");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte,\xe2\x80\xa6", String::truncate($s, 10), "length=10");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte,\xe2\x80\xa6", String::truncate($s, 11), "length=11");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte,\xe2\x80\xa6", String::truncate($s, 12), "length=12");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak\xe2\x80\xa6", String::truncate($s, 13), "length=13");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak\xe2\x80\xa6", String::truncate($s, 14), "length=14");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak\xe2\x80\xa6", String::truncate($s, 15), "length=15");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak se\xe2\x80\xa6", String::truncate($s, 16), "length=16");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak se \xe2\x80\xa6", String::truncate($s, 17), "length=17");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak se \xe2\x80\xa6", String::truncate($s, 18), "length=18");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak se \xe2\x80\xa6", String::truncate($s, 19), "length=19");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak se \xe2\x80\xa6", String::truncate($s, 20), "length=20");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak se \xe2\x80\xa6", String::truncate($s, 21), "length=21");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak se (dnes\xe2\x80\xa6", String::truncate($s, 22), "length=22");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak se (dnes)\xe2\x80\xa6", String::truncate($s, 23), "length=23");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak se (dnes)\xe2\x80\xa6", String::truncate($s, 24), "length=24");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak se (dnes)\xe2\x80\xa6", String::truncate($s, 25), "length=25");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak se (dnes)\xe2\x80\xa6", String::truncate($s, 26), "length=26");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak se (dnes)\xe2\x80\xa6", String::truncate($s, 27), "length=27");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak se (dnes) m\xc3\xa1te?", String::truncate($s, 28), "length=28");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak se (dnes) m\xc3\xa1te?", String::truncate($s, 29), "length=29");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak se (dnes) m\xc3\xa1te?", String::truncate($s, 30), "length=30");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak se (dnes) m\xc3\xa1te?", String::truncate($s, 31), "length=31");
		$this->assertEquals("\xc5\x98ekn\xc4\x9bte, jak se (dnes) m\xc3\xa1te?", String::truncate($s, 32), "length=32");
	}

}