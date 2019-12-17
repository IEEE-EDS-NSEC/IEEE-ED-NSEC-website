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


$columns = 2;

//
// Create all galleries
//
function create_all_galleries($options) {


	$UIKP=$GLOBALS['UIKP'];
	
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
	$width            = "$UIKP-width-1-1 $UIKP-width-4-5@m"; // UIKit3-sytle with of the inline slideshow. Standard UIKit3 prefix uk- must be repalced by $UIKP- 
	$mode             = "lightbox"; // Type of gallery, can be lightbix, slideshow, gallery of gallery-slideshow
	$thumbsmax        = 25; // Maximum number of thumbs / resized images to greate in one go.
	$shuffle          = false; // Shuffle the images (=random order)
	$ratio			  = "3:2"; // Image aspect ratio
	$columns 		  = "3"; 
	$finite			  = "false";
	$sets			  = "false";
	
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
		
	if (isset($options['columns']))
		$columns = $options['columns'];
		
	if (isset($options['sets']))
		$sets = $options['sets'];
	
	switch ($mode) {
		
		case "slider":
		case "inline":
		case "slideshow":
		case "lightbox":
		case "inline-single":
			
			$images = files($GLOBALS['mercator_gallery_storage'], $files);
			$html .= create_gallery($images, $mode, $shuffle, $position, $width, $ratio, $animation, $columns, $autoplay, $sets,  $duration, $imagesize, $thumbsize, $thumbsquare, $imagecompression, $thumbcompression);
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
			$html .= "<ul $UIKP-accordion='multiple: true'>";
			$opended = "class='$UIKP-open' ";
			foreach ($dirs as $subdir) {
				
				$subDirName=basename($subdir);
				$html .= "<li $opended><a class='$UIKP-accordion-title' href='#'>$subDirName</a><div class='$UIKP-accordion-content'><div>";
				
				$images = files("$subdir/*");
				switch ($mode) {
					case "galleries":
					case "galleries-slideshow":
					case "accordion":
					case "galleries-lightbox":
					case "accordion-lightbox":
						
						$html .= create_gallery($images, "lightbox", $shuffle, $position, $width, $ratio, $animation, $columns, $autoplay, $sets, $duration, $imagesize, $thumbsize, $thumbsquare, $imagecompression, $thumbcompression);
						break;
					case "galleries-inline":
					case "accordion-inline":
						$html .= create_gallery($images, "slideshow", $shuffle, $position, $width, $ratio, $animation, $columns, $autoplay, $sets, $duration, $imagesize, $thumbsize, $thumbsquare, $imagecompression, $thumbcompression);
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
function create_gallery($images, $mode, $shuffle, $position, $width, $ratio, $animation, $columns, $autoplay, $sets, $duration, $imagesize, $thumbsize, $thumbsquare, $imagecompression, $thumbcompression) {
	
	// Create empty return string
	$html = "";
	
	$UIKP=$GLOBALS['UIKP'];
	
	// Shuffle images
	if ($shuffle || !strcmp($mode, "inline-single"))
		shuffle($images); // shuffle images
	
	// Create gallery start
	switch ($mode) {
	
		case "slider":
			$html .= "<div class='$UIKP-flex $UIKP-flex-$position'>";
			$html .= "<div class='$width'>";
			$html .= "<div class='$UIKP-position-relative $UIKP-visible-toggle $UIKP-light' $UIKP-slider='autoplay: $autoplay; autoplay-interval: $duration; delay-controls: 1000; sets: $sets; finite: false; '>";
			$html .= "<ul class='$UIKP-slider-items $UIKP-child-width-1-$columns $UIKP-grid-small'>";
			break;
		
		case "inline":
		case "inline-single":
		case "slideshow": // this option is deprecated and will be removed in a later version
			
			$html .= "<div class='$UIKP-flex $UIKP-flex-$position'>";
			$html .= "<div class='$width'>";

			$html .= "<div class='$UIKP-position-relative $UIKP-visible-toggle $UIKP-light ' $UIKP-slideshow='autoplay: $autoplay; autoplay-interval: $duration; delay-controls: 1000; animation: $animation; ratio: $ratio'><ul class='$UIKP-slideshow-items'>";
			break;
		
		case "lightbox":
		default:
			
			// $autoplay = "false"; // set to false as UIKit3 RC17 has a bug
			$html .= "<div $UIKP-lightbox='animation: $animation; autoplay: $autoplay; delay-controls: 1000; autoplay-interval: $duration'><div class='$UIKP-grid-small ' $UIKP-grid>";
			break;
	}
	
	
	$storageDir = $GLOBALS['mercator_gallery_storage'] . "/"; // Location of Pagekit's Storage directory on the server, must end with a slash
	
	// Iterate over all images and create the actual lighbox, slideshow or gallery
	
	$i = 0;
	foreach ($images as $image) {
		
		$i = $i + 1;
		
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
			deleteDirectories(dirname($image) . '/_gallery42_thumbs-*');
			@mkdir($thumbDir);
		}
		if (!is_dir($resizeDir)) {
			deleteDirectories(dirname($image) . '/_gallery42_resized-*');
			@mkdir(rtrim($resizeDir, "/"));
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
		
			case "slider":
				$html .= "<li><img src='$resizeImageHTML' alt=''>";
				$html .= "<div class='$UIKP-position-center $UIKP-panel'></div>";
				$html .= "</li>";
				break;
			
			case "inline":
			case "inline-single":
			case "slideshow": // this option is deprecated and will be removed in a later version
				
				$html .= "<li><img src='$resizeImageHTML' alt='' $UIKP-img $UIKP-flex-beween></li>";
				break;
			
			case "lightbox":
			default:
				
				$html .= "<a class='$UIKP-inline' href='$resizeImageHTML' $UIKP-img>";
				$html .= "<img src='$thumbImageHTML' alt='' $UIKP-grid-small $UIKP-img></a>";
				break;
		}
		
		// If only one image should be shown, break here
		if (!strcmp($mode, "inline-single"))
			break;
		
	}
	
	// Create gallery end
	switch ($mode) {
	
		case "slider":
		
			 $html .=  "</ul><a class='$UIKP-position-center-left $UIKP-position-small $UIKP-hidden-hover' href='#' $UIKP-slidenav-previous $UIKP-slider-item='previous'></a>";
   			 $html .=  "<a class='$UIKP-position-center-right $UIKP-position-small $UIKP-hidden-hover' href='#' $UIKP-slidenav-next $UIKP-slider-item='next'></a>";
			 $html .=  "</div></div></div>";
			break;
				
		case "inline":
		case "inline-single":
		case "slideshow": // this option is deprecated and will be removed in a later version
			$html .= "</ul>";
			$html .= "<a class='$UIKP-position-center-left $UIKP-position-small $UIKP-hidden-hover' href='#' $UIKP-slidenav-previous $UIKP-slideshow-item='previous'></a>";
			$html .= "<a class='$UIKP-position-center-right $UIKP-position-small $UIKP-hidden-hover' href='#' $UIKP-slidenav-next $UIKP-slideshow-item='next'></a>";
			$html .= "</div></div></div><div class='uk-margin-small-bottom'></div>";
			break;
		
		case "lightbox":
		default:
			$html .= "</div></div><div class='uk-margin-small-bottom'></div>";
			break;
	}
	return $html;
	
}
?>