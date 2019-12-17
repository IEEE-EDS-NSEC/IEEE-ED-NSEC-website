<?php

/*

Mercator Gallery Extension for Pagekit
Copyright (C) 2018 Helmut Kaufmann

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.

*/


//
// Resize an image (JPG, GIF, PNG)
//
// $src					A file name pointing to an image or an image resource (e.g., returned from a previous call)
// $dest				A file name where the resized image will be written
// $targetWidth			Width of the resized image, set to 0 to scale proportinally to $targetHeight
// $targetHeight		Height of the ressized image, set to 0 to scale proportinally to $targetWidth 
// $jpgQuality			Compression factor to be used when saving
// $proportional		Keep proportions
//
function resize_image($src, $dest, $targetWidth, $targetHeight, $jpgQuality=50, $proportional=true, $destroyOriginal=false) 
{
	
	// Re-use image (and do not reload from disk if passed on as $src)
	if (!strcmp(gettype($src), "array")) {
		$img=$src["image"];
		$keepAlpha = $src["alpha"];
	}
	else {
		$img=NULL;
		//echo "*in : $src * ";
	}

	//OPEN THE IMAGE INTO A RESOURCE
		if(!$img)
	{
		$img = @imagecreatefrompng ($src);	//try png
		if($img) $keepAlpha=true;
	}
	
	if(!$img) {
		$img = @imagecreatefromjpeg ($src);	//try jpg
		if($img) $keepAlpha=false;
	}
	
	if(!$img)
	{
		$img = @imagecreatefromgif ($src);	//try gif
		if($img) $keepAlpha=false;
	}
	
	if(!$img)
	{
		die("Could not create image resource $src");
	}
	
	// Get dimension of the original image
	$currentWidth=imagesx($img);
	$currentHeight=imagesy($img);
	
	if ($proportional) {
		if ($targetWidth  == 0)
      		$factor = $targetHeight / $currentHeight;
      	elseif  ($targetHeight == 0)  
      		$factor = $targetWidth / $currentWidth;
      	else
      		$factor = min( $targetWidth / $currentWidth, $targetHeight / $currentHeight);
      		
      	$resizedWidth  = round( $currentWidth * $factor );
      	$resizedHeight = round( $currentHeight * $factor );
    }
    else {
      	$resizedWidth = ( $targetWidth <= 0 ) ? $currentWidth : $targetWidth;
     	$resizedHeight = ( $targetHeight <= 0 ) ? $currentHeight : $targetHeight;
    }
    
	// Create new image resource and ensure ...
	if(!$imageResized = imagecreatetruecolor($resizedWidth, $resizedHeight))
	{
		die("Could not create new image resource of width : $resizedWidth , height : $resizedHeight");
	};
	
	// ...and ensure it is transparanet if needed
	if ($keepAlpha) {
		$keepAlpha = imagecolorallocatealpha( $img, 0, 0, 0, 127 ); 
		imagefill( $imageResized, 0, 0, $keepAlpha ); 
		imagealphablending($imageResized, false);
	}
	
	// Resize image
	if(! imagecopyresampled($imageResized, $img, 0, 0, 0, 0, $resizedWidth, $resizedHeight, $currentWidth, $currentHeight))
	{
		die('Resampling failed');
	}
	
	// Store image
	if (!$keepAlpha) {
		imagejpeg($imageResized, $dest, $jpgQuality);
		// echo "*out : $dest * ";
		}
	else {
		imagesavealpha($imageResized, true);
		imagepng($imageResized, $dest, 8);
	}

	//Free the memory
	imagedestroy($imageResized);
	if ($destroyOriginal) {
		imagedestroy($img);
		return null;
	}
	else {
		$image = array ( "alpha" => $keepAlpha, "image" => $img);
		return $image;
	}
}


// Filter for non-thumb and non-resized entries
function nonThumbDirs($dir) {

	if (strpos($dir, '_gallery') !== false)
		return 0;
	else 
		return 1;
}


// Get all sub-directories of a directory
function subDirectories($dir) {

	$dirs = array_filter(glob("$dir", GLOB_NOCHECK), "is_dir");
	// print_r( $dirs);
	return $dirs;
	
}

// Return all on-thumb and non-resized image directories
function subDirectoriesNonThumbs($dir, $subdir) {

	$subdirs=explode("::", $subdir);
	$retDir = array();
	foreach ($subdirs as $element) {
		$retDir = array_merge(subDirectories("$dir/$element"), $retDir);
	};
	$retDir = array_filter($retDir, 'nonThumbDirs');
	// print_r( $retDir);
	return array_unique($retDir);
	
}

// Return all files
function files($dir, $subdir="") {

	$subdirs=explode("::", $subdir);
	$retFiles = array();
	foreach ($subdirs as $element) {
		$files = array_filter(glob("$dir/$element"), "is_file");
		asort($files, $sort_flag = SORT_NATURAL); // Sort the images 
		$retFiles = array_merge($retFiles, $files);
	};
	// print_r( $retFiles);
	return array_unique($retFiles);
	
}

// Remove directories matching certain patterns
function deleteDirectories($dirname) {
	
	$dirs=glob($dirname);
	foreach ($dirs as $dir) { 
  		array_map("unlink", glob("$dir/*"));
  		if (is_dir($dir))
  			rmdir($dir);
  	}
}
?>