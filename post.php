<?php
// Register the post meta box.
add_action('add_meta_boxes', "itv_hero_meta_box");
function itv_hero_meta_box() {
	$pages = array('post', 'page');
	foreach ($pages as $page) {
		add_meta_box("itv_hero_meta_box_upload", "Hero Image", "itv_hero_meta_box_callback", $page, 'side', 'high');
	};
};

// Meta box callback function.
function itv_hero_meta_box_callback($post) {
	wp_nonce_field("itv_hero_nonce_action", "itv_hero_meta_nonce");
	$image_value = get_post_meta($post->ID, "itv_hero_value", true);
	echo "<input id=\"upload_image\" type=\"hidden\" name=\"itv_hero_uploaded_image\" value=\"" . esc_attr( $image_value ) . "\" />";
	echo "<input id=\"upload_image_button\" class=\"button\" type=\"button\" value=\"Choose Image\" />";
	echo "<img src=\"" . esc_attr( $image_value ) . "\" class=\"itv_hero_image_admin\"/>";
};

// Save the data... 
function itv_hero_save_meta( $post_id ) {
  // Check for the nonce
  if ( ! isset( $_POST["itv_hero_meta_nonce"] ) )
    return $post_id;
  $nonce = $_POST["itv_hero_meta_nonce"];
  // Verify the nonce...
  if ( ! wp_verify_nonce( $nonce, "itv_hero_nonce_action" ) )
      return $post_id;
  // Don't do anything on autosave
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;
  // Check that the admin has permissions
  if ( 'page' == $_POST['post_type'] || 'post' == $_POST['post_type']) {
    if ( ! current_user_can( 'edit_page', $post_id ) )
        return $post_id;
  }
  // Sanitize user input. We only want integers and decimals
  $itv_hero_to_save = $_POST["itv_hero_uploaded_image"];

  // Update the meta field in the database.
  update_post_meta( $post_id, "itv_hero_value", $itv_hero_to_save );
}
add_action( 'save_post', 'itv_hero_save_meta' );
?>