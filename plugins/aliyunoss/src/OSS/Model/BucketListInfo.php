<?php
//zend by 旺旺dongshaolin2008所有  禁止倒卖 一经发现停止任何服务
namespace OSS\Model;

class BucketListInfo
{
	/**
     * BucketInfo信息列表
     *
     * @var array
     */
	private $bucketList = array();

	public function __construct(array $bucketList)
	{
		$this->bucketList = $bucketList;
	}

	public function getBucketList()
	{
		return $this->bucketList;
	}
}


?>
