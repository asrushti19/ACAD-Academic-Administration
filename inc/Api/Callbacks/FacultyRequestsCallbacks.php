<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class FacultyRequestsCallbacks extends BaseController {
  public function acadFacultyRequestsSection() {
    echo "<h3> FacultyRequests Creation </h3>";
  }

  public function displayFacultyRequestsAction() {
    echo '<input type="hidden" name="action" value="add_faculty_requests_action">';
  }

  public function displayFacultyID() {
    global $wpdb;
    $table = $wpdb->prefix.'acad_faculty';
    $rows = $wpdb->get_results( "SELECT * FROM $table" );

    echo '<select name="faculty_id">';
    foreach ($rows as $row ) {
      //echo $row->DepartmentID . " ";
      echo '<option value="'. $row->FacultyID . '"> '.$row->FacultyName .'</option>';
    }
    echo '</select>';
  }

  public function displayFacultyRequestSubject() {
    $value = esc_attr( get_option('faculty_request_subject') );
    echo '<input type="text" class="regular-text" name="faculty_request_subject" value="' . $value . '" placeholder="Faculty Request Subject">';
  }

  public function displayFacultyRequestDetails() {
    $value = esc_attr( get_option('faculty_request_details') );
      echo '<input type="text" class="regular-text" name="faculty_request_details" value="' . $value . '" placeholder="Faculty Request Details">';
  }

  public function displayFacultyRequestTypeID() {
    global $wpdb;
    $table = $wpdb->prefix.'acad_faculty_request_types';
    $rows = $wpdb->get_results( "SELECT * FROM $table" );

    echo '<select name="faculty_request_type_id">';
    foreach ($rows as $row ) {
      //echo $row->DepartmentID . " ";
      echo '<option value="'. $row->FacultyRequestTypeID . '"> '.$row->FacultyRequestTypeName .'</option>';
    }
    echo '</select>';
  }


  public function displayFacultyRequestStatus() {
    $value = esc_attr( get_option('faculty_request_status') );
    echo '<input type="text" class="regular-text" name="faculty_request_status" value="' . $value . '" placeholder="Faculty Request Status">';
  }

  public function displayFacultyRequestsUpdateListAction() {
    echo '<input type="hidden" name="action" value="update_faculty_request_getID_action">';
  }

  public function displayFacultyRequestsUpdateID( $id ) {
    echo '<input type="hidden" name="faculty_request_id" value="'. $id . '">';
  }

  public function addFacultyRequests() {

    if( current_user_can('add_faculty_requests') ) {
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_faculty_requests';

      $check = $wpdb->insert( $table,
        array(
          'FacultyID' => $_POST['faculty_id'],
  			  'FacultyRequestSubject' => $_POST['faculty_request_subject'],
  			  'FacultyRequestDetails' => $_POST['faculty_request_details'],
  			  'FacultyRequestTypeID' => $_POST['faculty_request_type_id'],
  			  'FacultyRequestStatus' => $_POST['faculty_request_status']
        )
      );

      wp_redirect(admin_url('admin.php?page=acad_faculty_requests'));
    }

    else {
      echo "You are not autorized to add a new FacultyRequests";
    }
  }

  public function viewFacultyRequestss() {
    if( current_user_can('add_faculty_requests') || current_user_can('view_faculty_requestss') ) {
      global $wpdb;

      $table = $wpdb->prefix.'acad_faculty';
      $table = $wpdb->prefix.'acad_faculty_request_types';
      $table = $wpdb->prefix.'acad_faculty_requests';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

			echo '<table class="widefat", width="100%">
	  		<thead>
	    		<tr>
	      		<th>Faculty ID</th>
	      		<th>Qualification Name</th>
	      		<th>College Name</th>
	      		<th>Qualification Level</th>
	      		<th>FacultyRequestStatus</th>
            </tr>
	  		</thead>
	  		<tbody>';
	      	foreach($rows as $row){
            echo "<tr ><td>".$row->FacultyID."</td><td>".$row->FacultyRequestSubject."</td><td> ".$row->FacultyRequestDetails."</td><td>".$row->FacultyRequestTypeID."</td><td> ".$row->FacultyRequestStatus."</td></tr>\n";
         }
	      echo '</tbody>
			</table>';
    }
  }

  public function updateFacultyRequests() {
    if( current_user_can('update_FacultyRequests') ) {

    }

    }
  }

?>
