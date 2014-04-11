<?php
function itv_hero_image() {
	global $post;
	$image_value = esc_attr(get_post_meta($post->ID, "itv_hero_value", true));
	if ($image_value) {
		echo "<div class=\"hero_image_wrapper\"><img class=\"hero_image\" src=\"{$image_value}\" /></div>";
	} else {
		$images = get_option("itv_hero_options");
		$key = array_rand($images);
		echo "<div class=\"hero_image\"><img class=\"hero_image\" src=\"{$images[$key]}\" /></div>";
	};
};

?>