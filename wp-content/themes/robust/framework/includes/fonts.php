<?php


function freshthemes_typography_get_google_fonts() {
	$google_faces = array(
		'Abel, sans-serif' => 'Abel',
		'Arimo, san-serif' => 'Arimo',
		'Arvo, serif' => 'Arvo',
		'Asap, sans-serif' => 'Asap',
		'Bitter, serif' => 'Bitter',
		'Cabin, sans-serif' => 'Cabin',
		'Cantarell, sans-serif' => 'Cantarell',
		'Carrois Gothic, sans-serif' => 'Carrois Gothic',
		'Cuprum, sans-serif' => 'Cuprum',
		'Droid Sans, sans-serif' => 'Droid Sans',
		'Droid Serif, serif' => 'Droid Serif',
		'Josefin Sans, sans-serif' => 'Josefin Sans',
		'Kreon, serif' => 'Kreon',
		'Lato, sans-serif' => 'Lato',
		'Lora, serif' => 'Lora',
		'Lobster, cursive' => 'Lobster',
		'Merriweather, serif' => 'Merriweather',
		'Nunito, sans-serif' => 'Nunito',
		'Nobile, sans-serif' => 'Nobile',
		'Open Sans, sans-serif' => 'Open Sans',
		'Oswald, sans-serif' => 'Oswald',
		'Philosopher, sans-serif' => 'Philosopher',
		'Play, sans-serif' => 'Play',
		'PT Sans, sans-serif' => 'PT Sans',
		'PT Serif, serif' => 'PT Serif',
		'Questrial, sans-serif' => 'Questrial',
		'Rokkitt, serif' => 'Rokkitt',
		'Source Sans Pro, sans-serif' => 'Source Sans Pro',
		'Ubuntu, sans-serif' => 'Ubuntu',
		'Vollkorn, serif' => 'Vollkorn',
		'Yanone Kaffeesatz, sans-serif' => 'Yanone Kaffeesatz',
	);
	
	return $google_faces;
}


function freshthemes_typography_get_os_fonts() {
	$os_faces = array(
		'Arial, Helvetica, sans-serif' => 'Arial',
		'Cambria, Georgia, serif' => 'Cambria',
		'Garamond, "Hoefler Text", Times New Roman, Times, serif' => 'Garamond',
		'Georgia, Times New Roman, Times, serif' => 'Georgia',
		'"Helvetica Neue", Helvetica, sans-serif' => 'Helvetica Neue',
		'"Lucida Sans Unicode", Arial, Helvetica, sans-serif' => 'Lucida Sans Unicode',
		'Verdana, Geneva, sans-serif' => 'Verdana',
		'Tahoma, Geneva, sans-serif' => 'Tahoma'
	);
	
	return $os_faces;
}

function freshthemes_typography_enqueue_google_font($font) {
	$font = explode(',', $font);
	$font = $font[0];
	
	if ($font == 'Arimo') $font = 'Arimo:400,700';
	if ($font == 'Arvo') $font = 'Arvo:400,700';
	if ($font == 'Asap') $font = 'Asap:400,700';
	if ($font == 'Bitter') $font = 'Bitter:400,700';
	if ($font == 'Cabin') $font = 'Cabin:400,500,600,700';
	if ($font == 'Cantarell') $font = 'Cantarell:400,700';
	if ($font == 'Droid Sans') $font = 'Droid Sans:400,700';
	if ($font == 'Droid Serif') $font = 'Droid Serif:400,700';
	if ($font == 'Josefin Sans') $font = 'Josefin Sans:300,400,600,700';
	if ($font == 'Kreon') $font = 'Kreon:300,400,700';
	if ($font == 'Lato') $font = 'Lato:300,400,700';
	if ($font == 'Lora') $font = 'Lora:400,700';
	if ($font == 'Merriweather') $font = 'Merriweather:300,400,700';
	if ($font == 'Nobile') $font = 'Nobile:700,400';
	if ($font == 'Nunito') $font = 'Nunito:300,400,700';
	if ($font == 'Open Sans') $font = 'Open Sans:400,300,600,700';
	if ($font == 'Oswald') $font = 'Oswald:300,400,700';
	if ($font == 'Philosopher') $font = 'Philosopher:400,700';
	if ($font == 'Play') $font = 'Play:400,700';
	if ($font == 'PT Sans') $font = 'PT Sans:400,700';
	if ($font == 'PT Serif') $font = 'PT Serif:400,700';
	if ($font == 'Rokkitt') $font = 'Rokkitt:400,700';
	if ($font == 'Source Sans Pro') $font = 'Source Sans Pro:300,400,600,700';
	if ($font == 'Ubuntu') $font = 'Ubuntu:300,400,500,700';
	if ($font == 'Vollkorn') $font = 'Vollkorn:400,700';
	if ($font == 'Yanone Kaffeesatz') $font = 'Yanone Kaffeesatz:300,400,700';
	
	$font = str_replace(' ', '+', $font);
	$font_id = str_replace(array(' ', '+', ':', ',', 'italic', '300', '400', '500', '600', '700'), '', $font);
	
	wp_enqueue_style( $font_id, "http://fonts.googleapis.com/css?family=$font", false, null, 'all' );
}

$fontawesome = array(
"" => "None", "adjust" => "Adjust","align-center" => "Align Center","align-justify" => "Align Justify","align-left" => "Align Left","align-right" => "Align Right","ambulance" => "Ambulance","angle-down" => "Angle Down","angle-left" => "Angle Left","angle-right" => "Angle Right","angle-up" => "Angle Up","arrow-down" => "Arrow Down","arrow-left" => "Arrow Left","arrow-right" => "Arrow Right","arrow-up" => "Arrow Up","asterisk" => "Asterisk","backward" => "Backward","ban-circle" => "Ban Circle","bar-chart" => "Bar Chart","barcode" => "Barcode","beaker" => "Beaker","beer" => "Beer","bell" => "Bell","bell-alt" => "Bell Alt","bold" => "Bold","bolt" => "Bolt","book" => "Book","bookmark" => "Bookmark","bookmark-empty" => "Bookmark Empty","briefcase" => "Briefcase","building" => "Building","bullhorn" => "Bullhorn","calendar" => "Calendar","camera" => "Camera","camera-retro" => "Camera Retro","caret-down" => "Caret Down","caret-left" => "Caret Left","caret-right" => "Caret Right","caret-up" => "Caret Up","certificate" => "Certificate","check" => "Check","check-empty" => "Check Empty","chevron-down" => "Chevron Down","chevron-left" => "Chevron Left","chevron-right" => "Chevron Right","chevron-up" => "Chevron Up","circle" => "Circle","circle-arrow-down" => "Circle Arrow Down","circle-arrow-left" => "Circle Arrow Left","circle-arrow-right" => "Circle Arrow Right","circle-arrow-up" => "Circle Arrow Up","circle-blank" => "Circle Blank","cloud" => "Cloud","cloud-download" => "Cloud Download","cloud-upload" => "Cloud Upload","coffee" => "Coffee","cog" => "Cog","cogs" => "Cogs","columns" => "Columns","comment" => "Comment","comment-alt" => "Comment Alt","comments" => "Comments","comments-alt" => "Comments Alt","copy" => "Copy","credit-card" => "Credit Card","cut" => "Cut","dashboard" => "Dashboard","desktop" => "Desktop","double-angle-down" => "Double Angle Down","double-angle-left" => "Double Angle Left","double-angle-right" => "Double Angle Right","double-angle-up" => "Double Angle Up","download" => "Download","download-alt" => "Download Alt","edit" => "Edit","eject" => "Eject","envelope" => "Envelope","envelope-alt" => "Envelope Alt","exchange" => "Exchange","exclamation-sign" => "Exclamation Sign","external-link" => "External Link","eye-close" => "Eye Close","eye-open" => "Eye Open","facebook" => "Facebook","facebook-sign" => "Facebook Sign","facetime-video" => "Facetime Video","fast-backward" => "Fast Backward","fast-forward" => "Fast Forward","fighter-jet" => "Fighter Jet","file" => "File","file-alt" => "File Alt","film" => "Film","filter" => "Filter","fire" => "Fire","flag" => "Flag","folder-close" => "Folder Close","folder-close-alt" => "Folder Close Alt","folder-open" => "Folder Open","folder-open-alt" => "Folder Open Alt","font" => "Font","food" => "Food","forward" => "Forward","fullscreen" => "Fullscreen","gift" => "Gift","github" => "Github","github-alt" => "Github Alt","github-sign" => "Github Sign","glass" => "Glass","globe" => "Globe","google-plus" => "Google Plus","google-plus-sign" => "Google Plus Sign","group" => "Group","h-sign" => "H Sign","hand-down" => "Hand Down","hand-left" => "Hand Left","hand-right" => "Hand Right","hand-up" => "Hand Up","hdd" => "HDD","headphones" => "Headphones","heart" => "Heart","heart-empty" => "Heart Empty","home" => "Home","hospital" => "Hospital","inbox" => "Inbox","indent-left" => "Indent Left","indent-right" => "Indent Right","info-sign" => "Info Sign","italic" => "Italic","key" => "Key","laptop" => "Laptop","leaf" => "Leaf","legal" => "Legal","lemon" => "Lemon","lightbulb" => "Lightbulb","link" => "Link","linkedin" => "Linkedin","linkedin-sign" => "Linkedin Sign","list" => "List","list-alt" => "List Alt","list-ol" => "List ol","list-ul" => "List ul","lock" => "Lock","magic" => "Magic","magnet" => "Magnet","map-marker" => "Map Marker","medkit" => "Medkit","minus" => "Minus","minus-sign" => "Minus Sign","mobile-phone" => "Mobile Phone","money" => "Money","move" => "Move","music" => "Music","off" => "Off","ok" => "Ok","ok-circle" => "Ok Circle","ok-sign" => "Ok Sign","paper-clip" => "Paper Clip","paste" => "Paste","pause" => "Pause","pencil" => "Pencil","phone" => "Phone","phone-sign" => "Phone Sign","picture" => "Picture","pinterest" => "Pinterest","pinterest-sign" => "Pinterest Sign","plane" => "Plane","play" => "Play","play-circle" => "Play Circle","plus" => "Plus","plus-sign" => "Plus Sign","plus-sign-alt" => "Plus Sign Alt","print" => "Print","pushpin" => "Pushpin","qrcode" => "QR Code","question-sign" => "Question Sign","quote-left" => "Quote Left","quote-right" => "Quote Right","random" => "Random","refresh" => "Refresh","remove" => "Remove","remove-circle" => "Remove Circle","remove-sign" => "Remove Sign","reorder" => "Reorder","repeat" => "Repeat","reply" => "Reply","resize-full" => "Resize Full","resize-horizontal" => "Resize Horizontal","resize-small" => "Resize Small","resize-vertical" => "Resize Vertical","retweet" => "Retweet","road" => "Road","rss" => "RSS","save" => "Save","screenshot" => "Screenshot","search" => "Search","share" => "Share","share-alt" => "Share Alt","shopping-cart" => "Shopping Cart","sign-blank" => "Sign Blank","signal" => "Signal","signin" => "Signin","signout" => "Signout","sitemap" => "Sitemap","sort" => "Sort","sort-down" => "Sort Down","sort-up" => "Sort Up","spinner" => "Spinner","star" => "Star","star-empty" => "Star Empty","star-half" => "Star Half","step-backward" => "Step Backward","step-forward" => "Step Forward","stethoscope" => "Stethoscope","stop" => "Stop","strikethrough" => "Strikethrough","suitcase" => "Suitcase","table" => "Table","tablet" => "Tablet","tag" => "Tag","tags" => "Tags","tasks" => "Tasks","text-height" => "Text Height","text-width" => "Text Width","th" => "th","th-large" => "th Large","th-list" => "th List","thumbs-down" => "Thumbs Down","thumbs-up" => "Thumbs Up","time" => "Time","tint" => "Tint","trash" => "Trash","trophy" => "Trophy","truck" => "Truck","twitter" => "Twitter","twitter-sign" => "Twitter Sign","umbrella" => "Umbrella","underline" => "Underline","undo" => "Undo","unlock" => "Unlock","upload" => "Upload","upload-alt" => "Upload Alt","user" => "User","user-md" => "User md","volume-down" => "Volume Down","volume-off" => "Volume Off","volume-up" => "Volume Up","warning-sign" => "Warning Sign","wrench" => "Wrench","zoom-in" => "Zoom In","zoom-out" => "Zoom Out"			
);