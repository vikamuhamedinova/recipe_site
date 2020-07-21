<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{
	private $uploadsPath;
	const RECIPE_IMAGES = 'recipe_images';
	
	public function __construct(string $uploadsPath)
    {
        $this->uploadsPath = $uploadsPath;
    }
	
	//uploading an image to the server
	public function uploadRecipeImage(UploadedFile $uploadedFile): string
    {
		$destination = $this->uploadsPath.'/'.self::RECIPE_IMAGES;
        
		$originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
        
		$uploadedFile->move(
            $destination,
            $newFilename
        );
		return $newFilename;
    }
}
