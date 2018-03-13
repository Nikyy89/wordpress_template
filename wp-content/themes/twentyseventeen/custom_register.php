<?php
/*
 ** Template Name: Custom Register Page
 */
get_header();

?>

<?php
global $wpdb, $user_ID;  
if (!$user_ID) {  
   //All code goes in here.  
}  
else {  
   wp_redirect( home_url() ); exit;  
}
?>