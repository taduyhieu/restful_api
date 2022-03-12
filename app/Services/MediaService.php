<?php
	namespace App\Services;
	use League\Flysystem\Exception;
	use Illuminate\Support\Facades\Storage;
	
	class MediaService
	{
		public function update($file, $folderName = '', $overwrite = false, $autoFileName = true, $forceFileName = '')
		{
			$fileOriginal = $file->getClientOriginalName();
			
			$fileName = pathinfo($fileOriginal, PATHINFO_FILENAME);
			$fileFormat = pathinfo($fileOriginal, PATHINFO_EXTENSION);
			if($autoFileName) {
				$fileAs = $this->convertNameFile($fileName) . '_' . time() . '.'. $fileFormat;
			} else {
				$fileAs = $forceFileName;
			}
			$result = Storage::disk('s3')->putFileAs($folderName, $file, $fileAs, 'public');
			return $result;
		}
		
		public function createDirectory($directoryName = '')
		{
			if(Storage::disk('s3')->exists($directoryName)){
				return false;
			}
			return Storage::disk('s3')->makeDirectory($directoryName);
		}
		
		private function convertNameFile($name)
		{
			$name = preg_replace('/[\/\s]+/', '_', $name);
			$name = preg_replace('/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/', "a", $name);
			$name = preg_replace('/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/', "e", $name);
			$name = preg_replace('/ì|í|ị|ỉ|ĩ/', "i", $name);
			$name = preg_replace('/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/', "o", $name);
			$name = preg_replace('/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/', "u", $name);
			$name = preg_replace('/ỳ|ý|ỵ|ỷ|ỹ/', "y", $name);
			$name = preg_replace('/đ/', "d", $name);
			$name = preg_replace('/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/', "A", $name);
			$name = preg_replace('/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/', "E", $name);
			$name = preg_replace('/Ì|Í|Ị|Ỉ|Ĩ/', "I", $name);
			$name = preg_replace('/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/', "O", $name);
			$name = preg_replace('/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/', "U", $name);
			$name = preg_replace('/Ỳ|Ý|Ỵ|Ỷ|Ỹ/', "Y", $name);
			$name = preg_replace('/Đ/', "D", $name);
			$name = preg_replace("/'/", "", $name);
			$name = preg_replace('/"/', "", $name);
			return $name;
		}
	}
