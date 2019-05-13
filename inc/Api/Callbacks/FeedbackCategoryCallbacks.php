<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class FeedbackCategoryCallbacks extends BaseController {
  public function acadFeedbackCategorySection() {
    echo "<h3> FeedbackCategory Creation </h3>";
  }

  public function displayFeedbackCategoryAction() {
    echo '<input type="hidden" name="action" value="add_feedback_category_action">';
  }

  public function displayFeedbackCategoryName() {
    $value = esc_attr( get_option('feedback_category_name') );
    echo '<input type="text" class="regular-text" name="feedback_category_name" value="' . $value . '" placeholder="Feedback Category Name">';
  }


  public function displayFeedbackCategoryUpdateListAction() {
    echo '<input type="hidden" name="action" value="update_feedback_category_getID_action">';
  }

  public function displayFeedbackCategoryUpdateID( $id ) {
    echo '<input type="hidden" name="feedback_category_id" value="'. $id . '">';
  }

  public function addFeedbackCategory() {

    if( current_user_can('add_feedback_category') ) {
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_feedback_category';

      $check = $wpdb->insert( $table,
        array(
          'FeedbackCategoryName' => $_POST['feedback_category_name']
        )
      );

      wp_redirect(admin_url('admin.php?page=acad_feedback_category'));
    }

    else {
      echo "You are not autorized to add a new FeedbackCategory";
    }
  }

  public function viewFeedbackCategories() {
    if( current_user_can('add_feedback_category') || current_user_can('view_feedback_categories') ) {
      global $wpdb;
      $table = $wpdb->prefix.'acad_feedback_category';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

			echo '<table class="widefat", width="100%">
	  		<thead>
	    		<tr>
	      		<th>FeedbackCategoryName</th>
            </tr>
	  		</thead>
	  		<tbody>';
	      	foreach($rows as $row){
            echo "<tr ><td>".$row->FeedbackCategoryName."</td></tr>\n";
         }
	      echo '</tbody>
			</table>';
    }
  }

  public function updateFeedbackCategory() {
    if( current_user_can('update_FeedbackCategory') ) {

    }

    }
  }

?>
