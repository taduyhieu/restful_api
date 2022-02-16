<?php
	namespace App\Services;
	use Illuminate\Support\Facades\Redis;
	use League\Flysystem\Exception;
	
	class RedisService
	{
		
		public function set($key, $data, $time_expire = false)
		{
			if (!$data) {
				return false;
			}
			
			if (is_array($data)) {
				$data = json_encode($data);
			}
			if ($time_expire) {
				$set = Redis::set($key, $data);
				$rs  = Redis::expire($key, $time_expire);
			} else {
				return Redis::set($key, $data);
			}
			
		}
		
		public function hSet($key, $index, $data, $time_expire = false)
		{
			if (!$data) {
				return false;
			}
			
			if (is_array($data)) {
				$data = json_encode($data);
			}
			if ($time_expire) {
				$set = Redis::hSet($key, $index, $data);
				$rs  = Redis::expire($key, $time_expire);
			} else {
				$set = Redis::hSet($key, $index, $data);
			}
			return $set;
		}
		
		public function hGet($key, $index, $arr = false)
		{
			$data = Redis::hGet($key, $index);
			return $data ? json_decode($data, $arr) : false;
			
		}
		
		public function hGetValue($key, $index)
		{
			return Redis::hGet($key, $index);
		}
		
		public function hMGet($key, $listKey)
		{
			$data = Redis::hMGet($key, $listKey);
			return $data;
		}
		
		public function hDel($key, $field)
		{
			$data =  Redis::hDel($key, $field);
			return $data;
		}
		
		
		public function hGetAll($key)
		{
			$data = Redis::hGetAll($key);
			return $data;
		}
		
		public function hKeys($key)
		{
			$data = Redis::hKeys($key);
			return $data;
		}
		
		public function ttl($key)
		{
			$data = Redis::ttl($key);
			return $data;
		}
		
		public function get($key, $arr = false)
		{
			$data = Redis::get($key);
			return $data ? json_decode($data, $arr) : false;
		}
		
		public function publish($key, $value)
		{
			if (!$key || !$value) {
				return false;
			}
			
			return Redis::publish($key, $value);
		}
		
		public function delete($key)
		{
			if (!$key) {
				return false;
			}
			return Redis::del($key);
		}
		
		public function deleteByKeyRelate($key)
		{
			if (!$key || $key == '*') {
				return false;
			}
			
			$keys = Redis::keys($key.'*');
			foreach ($keys as $value) {
				try {
					Redis::del($value);
				} catch (Exception $e) {
					return $e->getMessage();
				}
			}
			return true;
		}
		
		public function setLogRedis($key, $param)
		{
			$logRedisOld = $this->get($key, true);
			
			if ($logRedisOld) {
				$logRedisOld[] = $param;
				return $this->set($key, $logRedisOld);
			}
			
			$dataInsert   = [];
			$dataInsert[] = $param;
			return $this->set($key, $dataInsert);
		}
	}
