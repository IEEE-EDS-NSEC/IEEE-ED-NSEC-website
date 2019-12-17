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
// Include tools
//
require_once('MercatorGalleryHelper.php');

//
// Create all galleries
//
function create_all_galleries($options) {
	
	// Default  values
	$imagesize        = 2000; // Maximum width or height of the resized image
	$thumbsize        = 100; // Size of a thumbnail
	$imagecompression = 50; // Image compression level
	$thumbcompression = 80; // Thumbnail compression level
	$duration         = 3000; // Duration a slide is shown (ms)
	$autoplay         = "true"; // Automatically start slideshow/lightbox
	$thumbsquare      = "false"; // Create square thumbnails
	$animation        = "slide"; // Animation used for transition, can be slide, fade
	$position         = "center"; // Positioning of the inline slideshow, can be center (default), right or left
	$width            = "uk3-width-4-5"; // UIKit3-sytle with of teh inline slideshow. Stnadard UIKit3 prefix uk- must be repalced by uk3- 
	$mode             = "lightbox"; // Type of gallery, can be lightbix, slideshow, gallery of gallery-slideshow
	$thumbsmax        = 25; // Maximum number of thumbs / resized images to greate in one go.
	$shuffle          = false; // Shuffle the images (=random order)
	$ratio			  = "3:2"; // Image aspect ratio
	
	$html = "";
	
	// Ensure the user has specified an image directory that exists
	if (!isset($options["dir"]) && !isset($options["files"])) {
		$html .= ("***Oups: You wanted to display a gallery but did not set the 'dir' of 'files' option in the mercator_gallery plugin. Please contact the website administrator.***");
		return $html;
	};
	
	// Read user-supplied options
	if (isset($options["files"])) {
		$files = $options["files"];
	}
	
	if (isset($options["dir"])) {
		$files = $options['dir'] . "/*";
	}
	
	if (isset($options['animation']))
		$animation = $options['animation'];
	
	if (isset($options['mode']))
		$mode = $options['mode'];
	
	if (isset($options['position']))
		$position = $options['position'];
	
	if (isset($options['width']))
		$width = $options['width'];
	
	if (isset($options['duration']))
		$duration = $options['duration'];
	
	if (isset($options['thumbsize']))
		$thumbsize = $options['thumbsize'];
	
	if (isset($options['imagesize']))
		$imagesize = $options['imagesize'];
	
	if (isset($options['compression']))
		$imagecompression = $options['compression'];
	
	if (isset($options['thumbsquare']))
		$thumbsquare = $options['thumbsquare'];
	
	if (isset($options['autoplay']))
		$autoplay = $options['autoplay'];
	
	if (isset($options['shuffle']))
		$shuffle = $options['shuffle'];
		
	if (isset($options['ratio']))
		$ratio = $options['ratio'];
	
	switch ($mode) {
		
		case "inline":
		case "slideshow":
		case "lightbox":
		case "inline-single":
			
			$images = files($GLOBALS['mercator_gallery_storage'], $files);
			$html .= create_gallery($images, $mode, $shuffle, $position, $width, $ratio, $animation, $autoplay, $duration, $imagesize, $thumbsize, $thumbsquare, $imagecompression, $thumbcompression);
			break;
		
		case "galleries":
		case "galleries-slideshow":
		case "galleries-lightbox":
		case "galleries-inline":
		case "accordion":
		case "accordion-inline":
		case "accordion-lightbox":
			
			$storageDir  = $GLOBALS['mercator_gallery_storage'] . "/";
			$dirs = subDirectoriesNonThumbs($storageDir, $files);
			asort($dirs, $sort_flag = SORT_NATURAL);
			$html .= "<ul uk3-accordion='multiple: true'>";
			$opended = "class='uk3-open' ";
			foreach ($dirs as $subdir) {
				
				$subDirName=basename($subdir);
				$html .= "<li $opended><a class='uk3-accordion-title' href='#'>$subDirName</a><div class='uk3-accordion-content'><div>";
				
				$images = files("$subdir/*");
				switch ($mode) {
					case "galleries":
					case "galleries-slideshow":
					case "accordion":
					case "galleries-lightbox":
					case "accordion-lightbox":
						
						$html .= create_gallery($images, "lightbox", $shuffle, $position, $width, $ratio, $animation, $autoplay, $duration, $imagesize, $thumbsize, $thumbsquare, $imagecompression, $thumbcompression);
						break;
					case "galleries-inline":
					case "accordion-inline":
						$html .= create_gallery($images, "slideshow", $shuffle, $position, $width, $ratio, $animation, $autoplay, $duration, $imagesize, $thumbsize, $thumbsquare, $imagecompression, $thumbcompression);
						break;
				}
				$html .= "</div></li>";
				$opended = "";
			}
			$html .= "</ul>";
	}
	return $html;
}


//
// Create an individual gallery
//
function create_gallery($images, $mode, $shuffle, $position, $width, $ratio, $animation, $autoplay, $duration, $imagesize, $thumbsize, $thumbsquare, $imagecompression, $thumbcompression) {
	
	// Create empty return string
	$html = "";
	
	// Shuffle images
	if ($shuffle || !strcmp($mode, "inline-single"))
		shuffle($images); // shuffle images
	
	// Create gallery start
	switch ($mode) {
		
		case "inline":
		case "inline-single":
		case "slideshow": // this option is deprecated and will be removed in a later version
			
			$html .= "<div class='uk3-flex uk3-flex-$position'>";
			$html .= "<div class='$width'>";
			$html .= "<div class='uk3-position-relative uk3-visible-toggle uk3-light' uk3-slideshow='autoplay: $autoplay; autoplay-interval: $duration; delay-controls: 1000; animation: $animation; ratio: $ratio'><ul class='uk3-slideshow-items'>";
			break;
		
		case "lightbox":
		default:
			
			// $autoplay = "false"; // set to false as UIKit3 RC17 has a bug
			$html .= "<div uk3-lightbox='animation: $animation; autoplay: $autoplay; delay-controls: 1000; autoplay-interval: $duration'><div class='uk3-grid-small ' uk3-grid>";
			break;
	}
	
	
	$storageDir = $GLOBALS['mercator_gallery_storage'] . "/"; // Location of Pagekit's Storage directory on the server, must end with a slash
	
	// Iterate over all images and create the actual lighbox, slideshow or gallery
	foreach ($images as $image) {
		
		
		// Directory names for the thumb and resized image
		$resizeDir = dirname($image) . "/_gallery42_resized-$imagesize-$imagecompression/"; // must end with a slash
		$thumbDir  = dirname($image) . "/_gallery42_thumbs-$thumbsize-$thumbcompression-$thumbsquare/"; // must end with a slash
		
		// Names of the tumb and resized image
		$resizeImage = $resizeDir . basename($image);
		$thumbImage  = $thumbDir . basename($image);
		
		// HTML locatoon of thumbs and resized images
		$resizeImageHTML = ("storage/" . substr($resizeImage, strlen($storageDir), 999));
		$thumbImageHTML  = ("storage/" . substr($thumbImage, strlen($storageDir), 999));
		
		// Remove thumbs and resized images if size has changed
		// Create directories for thums and resized images
		if (!is_dir($thumbDir)) {
			@mkdir($thumbDir);
			deleteDirectories(basename($image) . '/_gallery42_thumbs-*');
		}
		if (!is_dir($resizeDir)) {
			deleteDirectories(basename($image) . '/_gallery42_resized-*');
			@mkdir($resizeDir);
		}
		
		
		// Create thumbs and resized images
		if (!file_exists($resizeImage))
			$img = resize_image($image, $resizeImage, $imagesize, $imagesize, $imagecompression, true, false);
		
		if (!file_exists($thumbImage)) {
			if (!strcmp($thumbsquare, "true"))
				resize_image((isset($img) ? $img : ($image)), $thumbImage, $thumbsize, $thumbsize, $thumbcompression, false, true);
			else
				resize_image((isset($img) ? $img : ($image)), $thumbImage, 0, $thumbsize, $thumbcompression, true, true);
		}
		
		if ($img) {
			imagedestroy($img);
			unset($img);
		}
		
		// Create actual gallery entry
		switch ($mode) {
			
			case "inline":
			case "inline-single":
			case "slideshow": // this option is deprecated and will be removed in a later version
				
				$html .= "<li><img src='$resizeImageHTML' alt='' uk3-img uk3-flex-beween></li>";
				break;
			
			case "lightbox":
			default:
				
				$html .= "<a class='uk3-inline' href='$resizeImageHTML' uk3-img>";
				$html .= "<img src='$thumbImageHTML' alt='' uk3-grid-small uk3-img></a>";
				break;
		}
		
		// If only one image should be shown, break here
		if (!strcmp($mode, "inline-single"))
			break;
		
	}
	
	// Iterate over all images a second time
	if (strcmp($mode, "inline-single")) {
	
	switch ($mode) {
		
		case "inline":
		case "inline-single":
		case "slideshow": // this option is deprecated and will be removed in a later version
			
			$html .= "</ul><div class='uk3-position-bottom-center uk3-position-small'>";
			$html .= "<ul class='uk3-thumbnav'>";
			break;
		
		case "lightbox":
		default:
			
		
	}
	
	$i=-1;
	foreach ($images as $image) {
		
		$i=$i+1;
		
		// Directory names for the thumb and resized image
		$resizeDir = dirname($image) . "/_gallery42_resized-$imagesize-$imagecompression/"; // must end with a slash
		$thumbDir  = dirname($image) . "/_gallery42_thumbs-$thumbsize-$thumbcompression-$thumbsquare/"; // must end with a slash
		
		// Names of the tumb and resized image
		$resizeImage = $resizeDir . basename($image);
		$thumbImage  = $thumbDir . basename($image);
		
		// HTML locatoon of thumbs and resized images
		$resizeImageHTML = ("storage/" . substr($resizeImage, strlen($storageDir), 999));
		$thumbImageHTML  = ("storage/" . substr($thumbImage, strlen($storageDir), 999));
		
		
		// Create actual gallery entry
		switch ($mode) {
			
			case "inline":
			case "inline-single":
			case "slideshow": // this option is deprecated and will be removed in a later version
				
				$html .= "<li uk3-slideshow-item='$i'><a href='#'><img src='$resizeImageHTML' width='80' alt=''></a></li>";
				break;
			
			case "lightbox":
			default:
				
		}
		

		
	}}
	
	// Create gallery end
	switch ($mode) {
		case "inline":
		case "inline-single":
		case "slideshow": // this option is deprecated and will be removed in a later version
			$html .= "</ul></div>";
			break;
		
		case "lightbox":
		default:
			break;
	}
	return $html;
	
}
?>