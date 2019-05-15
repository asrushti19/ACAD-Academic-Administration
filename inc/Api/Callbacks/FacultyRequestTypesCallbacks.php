<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class FacultyRequestTypesCallbacks extends BaseController {
  public function acadFacultyRequestTypesSection() {
    echo "<h3> FacultyRequestTypes Creation </h3>";
  }

  public function displayFacultyRequestTypesAction() {
    echo '<input type="hidden" name="action" value="add_faculty_request_types_action">';
  }

  public function displayFacultyRequestTypeName() {
    $value = esc_attr( get_option('faculty_request_type_name') );
    echo '<input type="text" class="regular-text" name="faculty_request_type_name" value="' . $value . '" placeholder="Faculty Request Type Name">';
  }


  public function displayFacultyRequestTypesUpdateListAction() {
    echo '<input type="hidden" name="action" value="update_faculty_request_types_getID_action">';
  }

  public function displayFacultyRequestTypesUpdateID( $id ) {
    echo '<input type="hidden" name="faculty_request_type_id" value="'. $id . '">';
  }

  public function addFacultyRequestTypes() {

    if( current_user_can('add_faculty_request_types') ) {
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_faculty_request_types';

      $check = $wpdb->insert( $table,
        array(
          'FacultyRequestTypeName' => $_POST['faculty_request_type_name']
        )
      );

      wp_redirect(admin_url('admin.php?page=acad_faculty_request_types'));
    }

    else {
      echo "You are not autorized to add a new FacultyRequestTypes";
    }
  }

  public function deleteFacultyRequestTypess() {
    if( current_user_can('add_faculty_request_types') || current_user_can('view_faculty_request_typess') ) {
      global $wpdb;
      $table = $wpdb->prefix.'acad_faculty_request_types';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

      echo '<table class="widefat", width="100%">
        <thead>
          <tr>
            <th>Faculty Request Type Name</th>
            </tr>
        </thead>
        <tbody>';
          foreach($rows as $row){
            echo "<tr ><td>".$row->FacultyRequestTypeName."</td></td>\n";
            echo '<td><form method="post"><input type="submit" name="delete" value="Delete"><input type="hidden" name="faculty_request_type_id" value="'.$row->FacultyRequestTypeID.'"></form></td>';

          if ($_POST) {
          global $wpdb;
              echo "Inside";
              $table = $wpdb->prefix . 'acad_faculty_request_types';
              $id = $_POST['faculty_request_type_id'];
              $res = $wpdb->query("DELETE FROM $table WHERE FacultyRequestTypeID = ".$id);

               echo "<meta http-equiv='refresh' content='0'>";
            }
         }
       }
     }

  public function viewFacultyRequestTypess() {
    if( current_user_can('add_faculty_request_types') || current_user_can('view_faculty_request_typess') ) {
      global $wpdb;
      $table = $wpdb->prefix.'acad_faculty_request_types';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

			echo '<table class="widefat", width="100%">
	  		<thead>
	    		<tr>
	      		<th>Faculty Request Type Name</th>
            </tr>
	  		</thead>
	  		<tbody>';
	      	foreach($rows as $row){
            echo "<tr ><td>".$row->FacultyRequestTypeName."</td></tr>\n";
         }
	      echo '</tbody>
			</table>';
    }
  }

  public function updateFacultyRequestTypes() {
    if( current_user_can('update_FacultyRequestTypes') ) {

    }

    }
  }

?>
