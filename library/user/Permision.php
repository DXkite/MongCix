<?php

namespace user; 

use archive\Archive;
use archive\Condition;
use archive\Statement;

class Permision implements Archive {
    protected static $_fields=['pid','uid','gid','upload'];
    /**
     * 权限ID 
     * @var  int 
     */
    protected $pid;
    /**
     * 用户ID 
     * @var  int 
     */
    protected $uid;
    /**
     * 分组ID 
     * @var  int 
     */
    protected $gid;
    /**
     * 上传文件 
     * @var  string 
     */
    protected $upload;



    /**
     * @return  Permision   
     */
    public function setPid(int $pid) {
        $this->pid=$pid;
        return $this;
    }

    /**
     * @return  int   
     */
    public function getPid() : int {
        return $this->pid;
    }


    /**
     * @return  Permision   
     */
    public function setUid(int $uid) {
        $this->uid=$uid;
        return $this;
    }

    /**
     * @return  int   
     */
    public function getUid() : int {
        return $this->uid;
    }


    /**
     * @return  Permision   
     */
    public function setGid(int $gid) {
        $this->gid=$gid;
        return $this;
    }

    /**
     * @return  int   
     */
    public function getGid() : int {
        return $this->gid;
    }


    /**
     * @return  Permision   
     */
    public function setUpload(string $upload) {
        $this->upload=$upload;
        return $this;
    }

    /**
     * @return  string   
     */
    public function getUpload() : string {
        return $this->upload;
    }
    function getFeilds():array
    {
        return self::$_fields;
    }
    function getAvailableFields():array
    {
        $available=[];
        foreach (self::$_fields as $name){
            if (isset($this->{$name})){
                $available[]=$name;
            }
        }
        return $available;
    }
    function tableCreator():string{
        return 'CREATE TABLE `user_permision` (
	`pid` bigint(20) NOT NULL  AUTO_INCREMENT COMMENT \'权限ID\',
	`uid` bigint(20) NOT NULL   COMMENT \'用户ID\',
	`gid` bigint(20) NOT NULL   COMMENT \'分组ID\',
	`upload` enum(\'Y\',\'N\') NOT NULL DEFAULT \'N\'  COMMENT \'上传文件\',
	PRIMARY KEY (`pid`),
	UNIQUE KEY `uid` (`uid`),
	UNIQUE KEY `gid` (`gid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;';
    }
    function sqlCreate():Statement{
		$values=self::getAvailableFields();
		$param=[];
		$bind='';
		$names='';
		foreach ($values as $name)
		{
			$bind.=':'.$name.',';
			$names.='`'.$name.'`,';
			$param[$name]=$this->{$name};
		}
		$sql='INSERT INTO `user_permision` ('.trim($names,',').') VALUES ('.trim($bind,',').');';
		return new Statement($sql,$param);
    }
    function sqlRetrieve(Condition $condition):Statement{
		
	}
    function sqlUpdate():Statement{}
    function sqlDelete():Statement{}
}

/**
* DTA FILE:
; 权限表
pid bigint(20) auto primary comment="权限ID"
uid bigint(20) unique  comment="用户ID"
gid bigint(20) unique  comment="分组ID"
upload enum('Y','N') default='N' comment="上传文件"
*/