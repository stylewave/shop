<?php
//zend by 旺旺dongshaolin2008所有  禁止倒卖 一经发现停止任何服务
namespace OSS\Tests;

class MimeTypesTest extends \PHPUnit_Framework_TestCase
{
	public function testGetMimeType()
	{
		$this->assertEquals('application/xml', \OSS\Core\MimeTypes::getMimetype('file.xml'));
	}
}

?>
