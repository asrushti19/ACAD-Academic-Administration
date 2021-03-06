<?php
/**
 * @package  Acad Plugin
 */
use Inc\Api\Callbacks\FeedbackCategoryCallbacks;
?>

<div class="wrap">
	<h1>Acad Plugin</h1>
	<?php settings_errors(); ?>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1">Add new</a></li>
		<li><a href="#tab-2">View</a></li>
		<li><a href="#tab-3">Edit</a></li>
		<li><a href="#tab-4">Delete</a></li>
	</ul>

	<div class="tab-content">
		<div id="tab-1" class="tab-pane active">

			<form method="post" action="<?php echo admin_url( 'admin-post.php'); ?>">
				<?php
					settings_fields( 'acad_feedback_category_options_group' );
					do_settings_sections( 'acad_feedback_category' );
					submit_button();
				?>
			</form>

		</div>

		<div id="tab-2" class="tab-pane">
			<h3>View</h3>

      <?php
				$feedback_category = new FeedbackCategoryCallbacks();
				$feedback_category->viewFeedbackCategories();
			?>

		</div>

		<div id="tab-3" class="tab-pane">
			<h3>Edit</h3>
		</div>

		<div id="tab-4" class="tab-pane">
			<h3>Delete</h3>
			<?php
				$feedback_category = new FeedbackCategoryCallbacks();
				$feedback_category->deleteFeedbackCategories();
			?>

		</div>
	</div>
</div>
