<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class FacultyResponsesCallbacks extends BaseController {
  public function acadFacultyResponsesSection() {
    echo "<h3> Faculty Responses Creation </h3>";
  }

  public function displayFacultyResponsesAction() {
    echo '<input type="hidden" name="action" value="add_faculty_responses_action">';
  }

  public function displayFacultyRequestID() {
    global $wpdb;
    $table = $wpdb->prefix.'acad_faculty_requests';
    $rows = $wpdb->get_results( "SELECT * FROM $table" );

    echo '<select name="faculty_request_id">';
    foreach ($rows as $row ) {
      //echo $row->DepartmentID . " ";
      echo '<option value="'. $row->FacultyRequestID . '"> '.$row->FacultyRequestID .'</option>';
    }
    echo '</select>';
  }


    public function displayFacultyID() {
      global $wpdb;
      $table = $wpdb->prefix.'acad_faculty';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

      echo '<select name="faculty_id">';
      foreach ($rows as $row ) {

        echo '<option value="'. $row->FacultyID . '"> '.$row->FacultyName .'</option>';
      }
      echo '</select>';
    }

  public function displayFacultyResponse() {
    $value = esc_attr( get_option('faculty_response') );
    echo '<input type="text" class="regular-text" name="faculty_response" value="' . $value . '" placeholder="Faculty Response">';
  }

  public function displayIsApproved() {
    $value = esc_attr( get_option('is_approved') );
      echo '<input type="text" class="regular-text" name="is_approved" value="' . $value . '" placeholder="Is Approved">';
  }


  public function displayFacultyResponsesUpdateListAction() {
    echo '<input type="hidden" name="action" value="update_faculty_responses_getID_action">';
  }

  public function displayFacultyResponsesUpdateID( $id ) {
    echo '<input type="hidden" name="faculty_responses_id" value="'. $id . '">';
  }

  public function addFacultyResponses() {

    if( current_user_can('add_faculty_responses') ) {
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_faculty_responses';

      $check = $wpdb->insert( $table,
        array(
          'FacultyRequestID' => $_POST['faculty_request_id'],
          'FacultyID' => $_POST['faculty_id'],
  			  'FacultyResponse' => $_POST['faculty_response'],
  			  'IsApproved' => $_POST['is_approved']
        )
      );

      wp_redirect(admin_url('admin.php?page=acad_faculty_responses'));
    }

    else {
      echo "You are not autorized to add a new FacultyResponses";
    }
  }

  public function viewFacultyResponsess() {
    if( current_user_can('add_faculty_responses') || current_user_can('view_faculty_responsess') ) {
      global $wpdb;

      $table = $wpdb->prefix.'acad_faculty_requests';
      $table = $wpdb->prefix.'faculty';
      $table = $wpdb->prefix.'acad_faculty_responses';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

			echo '<table class="widefat", width="100%">
	  		<thead>
	    		<tr>
            <th>FacultyRequestID</th>
	      		<th>Faculty ID</th>
	      		<th>Faculty Response</th>
	      		<th>Is Approved</th>
            </tr>
	  		</thead>
	  		<tbody>';
	      	foreach($rows as $row){
            echo "<tr ><td>".$row->FacultyRequestID."</td><td>".$row->FacultyID."</td><td> ".$row->FacultyResponse."</td><td>".$row->IsApproved."</td><td>\n";
         }
	      echo '</tbody>
			</table>';
    }
  }

  public function updateFacultyResponses() {
    if( current_user_can('update_FacultyResponses') ) {

    }

    }
  }

?>
