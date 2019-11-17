<?php
/**
 * Apply watermark image
 * http://github.com/josemarluedke/Watermark/apply
 * 
 * Copyright 2011, Josemar Davi Luedke <josemarluedke@gmail.com>
 * 
 * Licensed under the MIT license
 * Redistributions of part of code must retain the above copyright notice.
 * 
 * @author Josemar Davi Luedke <josemarluedke@gmail.com>
 * @version 0.1.1
 * @copyright Copyright 2010, Josemar Davi Luedke <josemarluedke.com>
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */
use JBZoo\Image\Image;
use JBZoo\Image\Filter;
use JBZoo\Image\Exception;

class Watermark {
	
	/**
	 * 
	 * Erros
	 * @var array
	 */
	public $errors = array();

	/**
	 * 
	 * Image Source
	 * @var img
	 */
	private $imgSource = null;

	/**
	 * 
	 * Image Watermark
	 * @var img
	 */
	private $imgWatermark = null;

	/**
	 * 
	 * Positions watermark
	 * 0: Centered
	 * 1: Top Left
	 * 2: Top Right
	 * 3: Footer Right
	 * 4: Footer left
	 * 5: Top Centered
	 * 6: Center Right
	 * 7: Footer Centered
	 * 8: Center Left
	 * @var number
	 */
	private $watermarkPosition = 0;
	
	/**
	 * 
	 * Check PHP GD is enabled
	 */
	public function __construct(){
		if(!function_exists("imagecreatetruecolor")){
			if(!function_exists("imagecreate")){
				$this->error[] = "You do not have the GD library loaded in PHP!";
			}
		}
	}

	/**
	 * 
	 * Get function name for use in apply
	 * @param string $name Image Name
	 * @param string $action |open|save|
	 */
	private function getFunction($name, $action = 'open') {
		if(preg_match("/^(.*)\.(jpeg|jpg)$/", $name)){
			if($action == "open")
				return "imagecreatefromjpeg";
			else
				return "imagejpeg";
		}elseif(preg_match("/^(.*)\.(png)$/", $name)){
			if($action == "open")
				return "imagecreatefrompng";
			else
				return "imagepng";
		}elseif(preg_match("/^(.*)\.(gif)$/", $name)){
			if($action == "open")
				return "imagecreatefromgif";
			else
				return "imagegif";
		}else{
			$this->error[] = "Image Format Invalid!";
		}
	}

	/**
	 * 
	 * Get image sizes
	 * @param object $img Image Object
	 */
	public function getImgSizes($img){
		return array('width' => imagesx($img), 'height' => imagesy($img));
	}

	/**
	 * Get positions for use in apply
	 * Enter description here ...
	 */
	public function getPositions(){
		$imgSource = $this->getImgSizes($this->imgSource);
		$imgWatermark = $this->getImgSizes($this->imgWatermark);
		$positionX = 0;
		$positionY = 0;

		# Centered
		if($this->watermarkPosition == 0){
			$positionX = ( $imgSource['width'] / 2 ) - ( $imgWatermark['width'] / 2 );
			$positionY = ( $imgSource['height'] / 2 ) - ( $imgWatermark['height'] / 2 );
		}

		# Top Left
		if($this->watermarkPosition == 1){
			$positionX = 0;
			$positionY = 0;
		}

		# Top Right
		if($this->watermarkPosition == 2){
			$positionX = $imgSource['width'] - $imgWatermark['width'];
			$positionY = 0;
		}

		# Footer Right
		if($this->watermarkPosition == 3){
			$positionX = ($imgSource['width'] - $imgWatermark['width']) - 5;
			$positionY = ($imgSource['height'] - $imgWatermark['height']) - 5;
		}

		# Footer left
		if($this->watermarkPosition == 4){
			$positionX = 0;
			$positionY = $imgSource['height'] - $imgWatermark['height'];
		}

		# Top Centered
		if($this->watermarkPosition == 5){
			$positionX = ( ( $imgSource['height'] - $imgWatermark['width'] ) / 2 );
			$positionY = 0;
		}

		# Center Right
		if($this->watermarkPosition == 6){
			$positionX = $imgSource['width'] - $imgWatermark['width'];
			$positionY = ( $imgSource['height'] / 2 ) - ( $imgWatermark['height'] / 2 );
		}

		# Footer Centered
		if($this->watermarkPosition == 7){
			$positionX = ( ( $imgSource['width'] - $imgWatermark['width'] ) / 2 );
			$positionY = $imgSource['height'] - $imgWatermark['height'];
		}

		# Center Left
		if($this->watermarkPosition == 8){
			$positionX = 0;
			$positionY = ( $imgSource['height'] / 2 ) - ( $imgWatermark['height'] / 2 );
		}

		return array('x' => $positionX, 'y' => $positionY);
	}

	/**
	 * 
	 * Apply watermark in image
	 * @param string $imgSource Name image source
	 * @param string $imgTarget Name image target
	 * @param string $imgWatermark Name image watermark
	 * @param number $position Position watermark
	 */
	public function apply($imgSource, $imgTarget,  $imgWatermark, $position = "lb", $size= 30, $opacity = 0.7){
		try { // Error handling
			if(file_exists($imgWatermark)){
				$functionSource = $this->getFunction($imgSource, 'open');
				$this->imgSource = $functionSource($imgSource);

				$functionWatermark = $this->getFunction($imgWatermark, 'open');
				$this->imgWatermark = $functionWatermark($imgWatermark);

				$sizesSource = $this->getImgSizes($this->imgSource);
				$sizesWatermark = $this->getImgSizes($this->imgWatermark);

				$width = $size/100*$sizesSource['width'];
				$height = ($width/$sizesWatermark['width'])*$sizesWatermark['height'];

				$imgWatermark_tmp = APPPATH."../assets/tmp/".md5(time()).".png";
				$resize = new ResizeImage($imgWatermark);
				$resize->resizeTo($width, $height, 'exact');
				$resize->saveImage($imgWatermark_tmp);

				switch ($position) {
					case 'lt':
						$pos = "top left";
						break;

					case 'ct':
						$pos = "top";
						break;

					case 'rt':
						$pos = "top right";
						break;

					case 'lc':
						$pos = "left";
						break;

					case 'cc':
						$pos = "center";
						break;

					case 'rc':
						$pos = "right";
						break;

					case 'rb':
						$pos = "bottom right";
						break;

					case 'cb':
						$pos = "bottom";
						break;
					
					default:
						$pos = "bottom left";
						break;
				}

		    	$img = new Image($imgSource);
		        $img->overlay($imgWatermark_tmp, $pos, $opacity, 0, 0);
		        $img->setQuality(100);
		        $img->saveAs($imgTarget, 100);

		        if(file_exists($imgWatermark_tmp)){
		        	unlink($imgWatermark_tmp);
		        }
		    }
		} catch(Exception $e) {
		    
		}
	}
}

class ResizeImage
{
	private $ext;
	private $image;
	private $newImage;
	private $origWidth;
	private $origHeight;
	private $resizeWidth;
	private $resizeHeight;

	/**
	 * Class constructor requires to send through the image filename
	 *
	 * @param string $filename - Filename of the image you want to resize
	 */
	public function __construct( $filename )
	{
		if(file_exists($filename))
		{
			$this->setImage( $filename );
		} else {
			throw new Exception('Image ' . $filename . ' can not be found, try another image.');
		}
	}

	/**
	 * Set the image variable by using image create
	 *
	 * @param string $filename - The image filename
	 */
	private function setImage( $filename )
	{
		$size = getimagesize($filename);
		$this->ext = $size['mime'];

		switch($this->ext)
	    {
	    	// Image is a JPG
	        case 'image/jpg':
	        case 'image/jpeg':
	        	// create a jpeg extension
	            $this->image = imagecreatefromjpeg($filename);
	            break;

	        // Image is a GIF
	        case 'image/gif':
	            $this->image = @imagecreatefromgif($filename);
	            break;

	        // Image is a PNG
	        case 'image/png':
	            $this->image = @imagecreatefrompng($filename);
	            break;

	        // Mime type not found
	        default:
	            throw new Exception("File is not an image, please use another file type.", 1);
	    }

	    $this->origWidth = imagesx($this->image);
	    $this->origHeight = imagesy($this->image);
	}

	/**
	 * Save the image as the image type the original image was
	 *
	 * @param  String[type] $savePath     - The path to store the new image
	 * @param  string $imageQuality 	  - The qulaity level of image to create
	 *
	 * @return Saves the image
	 */
	public function saveImage($savePath, $imageQuality="100", $download = false)
	{
	    switch($this->ext)
	    {
	        case 'image/jpg':
	        case 'image/jpeg':
	        	// Check PHP supports this file type
	            if (imagetypes() & IMG_JPG) {
	                imagejpeg($this->newImage, $savePath, $imageQuality);
	            }
	            break;

	        case 'image/gif':
	        	// Check PHP supports this file type
	            if (imagetypes() & IMG_GIF) {
	                imagegif($this->newImage, $savePath);
	            }
	            break;

	        case 'image/png':
	            $invertScaleQuality = 9 - round(($imageQuality/100) * 9);

	            // Check PHP supports this file type
	            if (imagetypes() & IMG_PNG) {
	                imagepng($this->newImage, $savePath, $invertScaleQuality);
	            }
	            break;
	    }

	    if($download)
	    {
	    	header('Content-Description: File Transfer');
			header("Content-type: application/octet-stream");
			header("Content-disposition: attachment; filename= ".$savePath."");
			readfile($savePath);
	    }

	    imagedestroy($this->newImage);
	}

	/**
	 * Resize the image to these set dimensions
	 *
	 * @param  int $width        	- Max width of the image
	 * @param  int $height       	- Max height of the image
	 * @param  string $resizeOption - Scale option for the image
	 *
	 * @return Save new image
	 */
	public function resizeTo( $width, $height, $resizeOption = 'default' )
	{
		switch(strtolower($resizeOption))
		{
			case 'exact':
				$this->resizeWidth = $width;
				$this->resizeHeight = $height;
			break;

			case 'maxwidth':
				$this->resizeWidth  = $width;
				$this->resizeHeight = $this->resizeHeightByWidth($width);
			break;

			case 'maxheight':
				$this->resizeWidth  = $this->resizeWidthByHeight($height);
				$this->resizeHeight = $height;
			break;

			default:
				if($this->origWidth > $width || $this->origHeight > $height)
				{
					if ( $this->origWidth > $this->origHeight ) {
				    	 $this->resizeHeight = $this->resizeHeightByWidth($width);
			  			 $this->resizeWidth  = $width;
					} else if( $this->origWidth < $this->origHeight ) {
						$this->resizeWidth  = $this->resizeWidthByHeight($height);
						$this->resizeHeight = $height;
					}
				} else {
		            $this->resizeWidth = $width;
		            $this->resizeHeight = $height;
		        }
			break;
		}

		$this->newImage = imagecreatetruecolor($this->resizeWidth, $this->resizeHeight);

 		imagealphablending($this->newImage, false);
	 	imagesavealpha($this->newImage,true);
		$transparent = imagecolorallocatealpha($this->newImage, 255, 255, 255, 127);
		imagefilledrectangle($this->newImage, 0, 0, $this->resizeWidth, $this->resizeHeight, $transparent);

    	imagecopyresampled($this->newImage, $this->image, 0, 0, 0, 0, $this->resizeWidth, $this->resizeHeight, $this->origWidth, $this->origHeight);
	}

	/**
	 * Get the resized height from the width keeping the aspect ratio
	 *
	 * @param  int $width - Max image width
	 *
	 * @return Height keeping aspect ratio
	 */
	private function resizeHeightByWidth($width)
	{
		return floor(($this->origHeight/$this->origWidth)*$width);
	}

	/**
	 * Get the resized width from the height keeping the aspect ratio
	 *
	 * @param  int $height - Max image height
	 *
	 * @return Width keeping aspect ratio
	 */
	private function resizeWidthByHeight($height)
	{
		return floor(($this->origWidth/$this->origHeight)*$height);
	}
}

