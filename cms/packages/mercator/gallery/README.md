Mercator Gallery Extension for Pagekit

Copyright (C) 2018 Helmut Kaufmann (software@mercator.li)

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

This plugin uses UIKit3 (https://getuikit.com).

To use this plugin within Pagekit:
- Create a directory with your images within Storage, e.g., "show1"
- To include the images on your page, simply use (mercator_gallery){"dir":"show1"} .
- The script will automatically produce a preview of the images.

Options (add after ""dir":"show1", eg. (mercator_gallery){"dir":"show1", "mode":"slideshow"}:
- "dir":"<directory location>				--- Location (directory) of the images, relative to "Storage"
- "files":"<files>"							--- Files to include in the gallery, relative to "Storage". This must point to FILES, not directories and you can use wildcards, e.g., "Test/A*" to display all images in the directory Test that begin with A.
- "mode":"lightbox"		 					---	Show thumbnails, which turn into a Lightbox when clicked upon. This is the default. 
- "mode":"slider"							---	Show an inline slideshow (using UIKit's slider).
- "mode":"randomimage"						--- Show a single, random image
- "mode":"accordion-slider" or "accordion-lightbox"	---	If you have multiples galleries in a directory (one sub-directory per gallery), show them as accordion.
- "animation":"slide", "scale", "fade" 		---	Type of animation to use when switching from one slide to the next.  Default is slide.
			  "pull", "push"  				---	For inline slide shows, "pull" and "push" are additonal options. If used with a lightbox, it will fall back to "slide".
- "position":"center" or "left" or "right"	--- Horizontal positioning of the inlide slideshow. Default is center.
- "shuffle":"true" or "false"				--- Shuffle (randomize) images before displaying them.
- "duration":"1000"							--- Milliseconds an individual slide is shown before moving to the next one. Default is 3000.
- "thumbsize":"100"							---	Size of the thumbnails shown. Default is 100.
- "thumbsquare":"true"						--- Squeeze thumbnails into a square without maintaining proportions. Default is false.
- "imagesize":"2000"						---	Size of the images shown. Default is 2000.
- "compression":"50"						---	JPEG compression factors (%) for images.

A special "thank you" to Sven Suchan, who has been instrumental in getting this into the Pagekit Marketplace.