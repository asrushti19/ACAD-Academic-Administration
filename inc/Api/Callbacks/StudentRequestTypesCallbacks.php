<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class StudentRequestTypesCallbacks extends BaseController {
  public function acadStudentRequestTypesSection() {
    echo "<h3> StudentRequestTypes Creation </h3>";
  }

  public function displayStudentRequestTypesAction() {
    echo '<input type="hidden" name="action" value="add_student_request_types_action">';
  }

  public function displayStudentRequestTypeName() {
    $value = esc_attr( get_option('student_request_type_name') );
    echo '<input type="text" class="regular-text" name="student_request_type_name" value="' . $value . '" placeholder="Student Request Type Name">';
  }


  public function displayStudentRequestTypesUpdateListAction() {
    echo '<input type="hidden" name="action" value="update_student_request_type_getID_action">';
  }

  public function displayStudentRequestTypesUpdateID( $id ) {
    echo '<input type="hidden" name="student_request_type_id" value="'. $id . '">';
  }

  public function addStudentRequestTypes() {

    if( current_user_can('add_student_request_types') ) {
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_student_request_types';

      $check = $wpdb->insert( $table,
        array(
          'StudentRequestTypeName' => $_POST['student_request_type_name']
        )
      );

      wp_redirect(admin_url('admin.php?page=acad_student_request_types'));
    }

    else {
      echo "You are not autorized to add a new StudentRequestTypes";
    }
  }

  public function viewStudentRequestTypess() {
    if( current_user_can('add_student_request_types') || current_user_can('view_student_request_typess') ) {
      global $wpdb;
      $table = $wpdb->prefix.'acad_student_request_types';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

			echo '<table class="widefat", width="100%">
	  		<thead>
	    		<tr>
	      		<th>Student Request Type Name</th>
            </tr>
	  		</thead>
	  		<tbody>';
	      	foreach($rows as $row){
            echo "<tr ><td>".$row->StudentRequestTypeName."</td></tr>\n";
         }
	      echo '</tbody>
			</table>';
    }
  }

  public function updateStudentRequestTypes() {
    if( current_user_can('update_StudentRequestTypes') ) {

    }

    }
  }

?>
