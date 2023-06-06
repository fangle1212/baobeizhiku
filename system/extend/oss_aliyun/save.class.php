<?php
/* 技术文档：https://help.aliyun.com/document_detail/32098.html */

function autoload($class){
	$path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
	$file = __DIR__ . DIRECTORY_SEPARATOR . $path . '.php';
	if (file_exists($file)) {
		require_once $file;
	}
}
spl_autoload_register('autoload');

use OSS\OssClient;
use OSS\Core\OssException;

class save
{
	public $msg;
	public $oss;
	
	public function __construct()
	{
		global $G;
		$this->oss = new OssClient($G['config']['store_id'], $G['config']['store_key'], "http://oss-{$G['config']['store_region']}.aliyuncs.com");
	}
	
	/* 
	 ** 按文件路径创建上传文件 
	 ** B OSS CMS
	 * @param string $path oss存储路径带文件名
	 * @param string $file 本地上传文件
	*/
	public function upload($path, $file)
	{
		global $G;
		try{
			$this->oss->uploadFile($G['config']['store_bucket'], $path, $file);
			return true;
		}catch(OssException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	
	/* 读取指定路径下的所有文件 */
	public function readall($path, $files=array())
	{
		global $G;
		$dir = self::read(dir::replace($path.'/'), true);
		foreach($dir['dir'] as $name){
			$files = self::readall($name, $files);
		}
		foreach($dir['file'] as $k=>$name){
			$files[$k] = dir::replace($name);
		}
		return $files;
	}
	
	/* 读取指定路径下的文件 */
	public function read($path, $type=false)
	{
		global $G;
		$dir = $file = array();
		$nextMarker = '';
		$boss_cms = true;
		$path = preg_replace("/^\//",'',$path);
		while(true){		
			try{
				$options = array(
					'delimiter' => '/',
					'prefix' => $path,
					'max-keys' => 1000,
					'marker' => $nextMarker
				);
				$listObjectInfo = $this->oss->listObjects($G['config']['store_bucket'], $options);
			}catch(OssException $e){
				$this->msg = $e->getMessage();
				return false;
			}
			if($prefixList = $listObjectInfo->getPrefixList()){
				foreach($prefixList as $prefixInfo){
					$dir[] = $type?$prefixInfo->getPrefix():trim(strReplace($path,'',$prefixInfo->getPrefix(),1),'/');
				}
			}
			if($objectList = $listObjectInfo->getObjectList()){
				foreach($objectList as $objectInfo){
					$file[$objectInfo->getLastModified().$objectInfo->getKey()] = $type?$objectInfo->getKey():strReplace($path,'',$objectInfo->getKey(),1);
				}
			}
			$nextMarker = $listObjectInfo->getNextMarker();
			if($listObjectInfo->getIsTruncated() !== "true"){
				break;
			}
		}
		return array('dir'=>$dir, 'file'=>$file);
	}
	
	/* 删除指定路径下的所有文件 boss cms */
	public function remove($path)
	{
		global $G;
		try{
			$path = dir::replace($path.'/');
			$result = self::read($path, true);
			self::delete($result['file']);
			foreach($result['dir'] as $dir){
				self::remove($dir);
			}
			return true;
		}catch(OssException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
	
	/* 删除指定路径下的文件 BOSS+CMS */
	public function delete($files)
	{
		global $G;
		try{
			if($files){
				if(is_array($files)){
					$this->oss->deleteObjects($G['config']['store_bucket'], $files);
				}else{
					$this->oss->deleteObject($G['config']['store_bucket'], $files);
				}
			}
			return true;
		}catch(OssException $e){
			$this->msg = $e->getMessage();
			return false;
		}
	}
}
?>