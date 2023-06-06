<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class mysql
{

    public static $link;
 
    public static function connect()
    {
		global $G;
        mysqli_report(MYSQLI_REPORT_OFF);
        if(self::$link = mysqli_connect($G['mysql']['host'], $G['mysql']['user'], $G['mysql']['password'], $G['mysql']['database'], $G['mysql']['port'])){
            mysqli_set_charset(self::$link, 'UTF8');
        }else{
            die('数据库连接失败');
        }
    }
	
	public static function query($query)
	{
		global $G;
		return mysqli_query(self::$link, $query);
	}

	/**
	 * 搜索数据
	 * 
	 * @param string $query
	 * @param boolean $single  是否只取单一结果；否则返回数组
	 * @return boolean
	 */
    public static function select($query, $single=false)
    {
		global $G;
        $result = self::$link->query($query);
        if($result && mysqli_num_rows($result)>0){
			if($single){
            	$rows = mysqli_fetch_array($result, MYSQLI_ASSOC);
			}else{
				while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
					$rows[] = $row;
				}
			}
        	mysqli_free_result($result);
        } else {
            $rows = array();
        }
        return $rows;
    }
	public static function select_one($select, $table, $where=true, $order=false ,$limit='0,1'){
		global $G;
		if($order){
			$order = "ORDER BY {$order}";
		}
		if($limit){
			$limit = "LIMIT {$limit}";
		}
		if($select == '*'){
			$select = $G['database_column'][$table];
		}
		$query = "SELECT {$select} FROM {$G['mysql']['prefix']}{$table} WHERE ".self::lang($table, $where)." AND ".self::filter($where)." {$order} {$limit}";
		return self::select($query, true);
	}
	public static function select_all($select, $table, $where=true, $order=false ,$limit=false){
		global $G;
		if($order){
			$order = "ORDER BY {$order}";
		}
		if($limit){
			$limit = "LIMIT {$limit}";
		}
		if($select == '*'){
			$select = $G['database_column'][$table];
		}
		$query = "SELECT {$select} FROM {$G['mysql']['prefix']}{$table} WHERE ".self::lang($table, $where)." AND ".self::filter($where)." {$order} {$limit}";
		return self::select($query, false);
	}
    public static function select_set($data, $table, $set=array())
	{
		global $G;
        $where = '';
		$update = array();
        foreach ($data as $key => $val) {
			if(in_array($key, $set)){
				$update[$key] = $val;
			}else{
            	$where .= $key."='{$val}' AND ";
			}
        }
		$where = trim($where, ' AND ');
		$total = self::total($table, $where);
		if($total){
			return self::update($update, $table, $where);
		}else{
			unset($data['id']);
			return self::insert($data, $table);
		}
	}
	
    /**
     * 增加数据
     * B o s s c m s
     * @param array $data
     * @param string $table
     * @return boolean
     */
    public static function insert($data, $table)
    {
		global $G;
		$keys = $vals = $kg = $vg = '';
		if(!isset($data['lang']) && self::lang($table,true)!=1){
			$data['lang'] = $G['language']['id'];
		}
		foreach($data as $k=>$v){
			$keys .= $kg.$k;
			$vals .= $vg.self::handle($v);
			$kg = ',';
			$vg = "','";
		}
        $query = "INSERT INTO {$G['mysql']['prefix']}{$table} (".self::filter($keys).") VALUES ('".self::filter($vals)."')";
        $result = self::$link->query($query);
        if($result){
            $id = mysqli_insert_id(self::$link);
        } else {
            $id = null;
        }
        return $id;
    }

    /**
     * 修改数据
     *
     * @param array $data
     * @param string $table
     * @param string $where
     * @return boolean
     */
    public static function update($data, $table, $where=true)
    {
		global $G;
        $set = '';
        foreach ($data as $key=>$val) {
			$g = $set?',':'';
            $set .= $g.$key."='".self::handle($val)."'";
        }
        $query = "UPDATE {$G['mysql']['prefix']}{$table} SET ".self::filter($set)." WHERE ".self::lang($table, $where)." AND ".self::filter($where);
        $result = self::query($query);
        if ($result) {
            $row = mysqli_affected_rows(self::$link);
        } else {
            $row = null;
        }
        return $row;
    }

    /**
     * 删除数据
     *
     * @param string $table
     * @param string $where
     * @return boolean
     */
    public static function delete($table, $where=true)
    {
		global $G;
        $query = "DELETE FROM {$G['mysql']['prefix']}{$table} WHERE ".self::lang($table, $where)." AND ".self::filter($where);
        $result = self::$link->query($query);
        if($result){
            $row = mysqli_affected_rows(self::$link);
        } else {
            $row = null;
        }
        return $row;
    }

    /**
     * 得到表中记录数
     * boss*cms
     * @param string $table
     * @return number|boolean
     */
    public static function total($table, $where=true)
    {
		global $G;
        $query = "SELECT COUNT(*) AS _total FROM {$G['mysql']['prefix']}{$table} WHERE ".self::lang($table, $where)." AND ".self::filter($where);
        $result = self::select($query, true);
		if ($result){
			$row = $result['_total'];
		} else {
			$row = null;
		}
        return $row;
    }
	
	/**
	 * 过滤注入关键词
	 */
	public static function filter($str)
	{
        $str = str_ireplace('insert', 'ins\ert', $str);
        $str = str_ireplace('select', 'sel\ect', $str);
        $str = str_ireplace('delete', 'de\lete', $str);
        $str = str_ireplace('update', 'upd\ate', $str);
        $str = str_ireplace('union', 'uni\on', $str);
        $str = str_ireplace('into', 'int\o', $str);
		$str = str_ireplace('exec', 'e\xec', $str);
		$str = str_ireplace('drop', 'dr\op', $str);
		$str = str_ireplace('declare', 'dec\lare', $str);
		$str = str_ireplace('truncate', 'trunc\ate', $str);
		$str = str_ireplace('master', 'm\aster', $str);
        $str = str_ireplace('sleep', 's\leep', $str);
        $str = str_ireplace('outfile', 'outfi\le', $str);
        $str = str_ireplace('load_file', 'lo\ad_fi\le', $str);
		return $str;
	}
	
	/**
	 * 将不带单引号的添加斜杆
	 */
	public static function handle($str)
	{
		return preg_replace_callback(
			"/\\\*'/",
			function($match){
				return (strlen($match[0])%2?'\\':'').$match[0];
			},
			$str
		);
	}
	
	/**
	 * 判断是否添加当前语言
	 */
	public static function lang($table, $where)
	{
		global $G;
		if(isset($G['database'][$table]['lang']) && ($where===true || !strstr($where,' lang='))){
			return "lang='{$G['language']['id']}'";
		}else{
			return 1;
		}
	}
	
    /**
     * 关闭数据库连接
     *
     */
	public static function close()
	{
		mysqli_close(self::$link);
	}
}