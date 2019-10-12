<?php

get_header();

?>

<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800"><?php echo get_the_title(); ?></h1>
</div>

<?php 
if ( have_posts() ) {
	while ( have_posts() ) {
        the_post();
        the_content();
	}
}
?>

</div>
  <!-- End of Main Content -->

<?php

get_footer();