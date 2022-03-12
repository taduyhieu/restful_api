<?php
	namespace App\Http\Controllers\Image;
	
	use App\Http\Controllers\ApiController;
	use App\Services\MediaService;
	use Illuminate\Http\Request;
	
	class ImageController extends ApiController
	{
		public function __construct(
			MediaService $mediaService
		){
			$this->mediaService = $mediaService;
		}
		public function store(Request $request) {
			$file = $request->file('file');

			if (!$file) {
				return $this->errorResponse('File không tồn tại', 422);
			}

			$results = $this->mediaService->update($request->file('file'), 'test');
			if(!$results) {
				$this->errorResponse('Đã có lỗi xảy ra', 422);
			}
			return $this->successResponse($results, 200);
		}
		
		public function createDirectory(Request $request) {
			$folderName = $request->input('folder_name');
			
			if (!$folderName) {
				return $this->errorResponse('Tên folder không có', 422);
			}
			$results = $this->mediaService->createDirectory($folderName);
			if(!$results) {
				return $this->errorResponse('Folder đã tồn tại', 422);
			}
			return $this->successResponse('Tạo mới folder thành công', 200);
		}
	}
