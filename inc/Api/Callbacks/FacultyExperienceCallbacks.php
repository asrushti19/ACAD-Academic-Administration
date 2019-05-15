<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class FacultyExperienceCallbacks extends BaseController {
  public function acadFacultyExperienceSection() {
    echo "<h3> Faculty Experience Creation </h3>";
  }
  public function displayFacultyExperienceAction() {
    echo '<input type="hidden" name="action" value="add_faculty_experience_action">';
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

  public function displayEmployerName() {
    $value = esc_attr( get_option('employer_name') );
    echo '<input type="text" class="regular-text" name="employer_name" value="' . $value . '" placeholder="Employer Name">';
  }

  public function displayDesignation() {
    $value = esc_attr( get_option('designation') );
      echo '<input type="text" class="regular-text" name="designation" value="' . $value . '" placeholder="Designation">';
  }

  public function displayFromDate() {
    $value = esc_attr( get_option('from_date') );
    echo '<input type="date" class="regular-text" name="from_date" value="' . $value . '" placeholder="From">';
  }

  public function displayToDate() {
    $value = esc_attr( get_option('to_date') );
    echo '<input type="date" class="regular-text" name="to_date" value="' . $value . '" placeholder="To">';
  }

  public function displayFacultyExperienceUpdateListAction() {
    echo '<input type="hidden" name="action" value="update_faculty_experience_getID_action">';
  }

  public function displayFacultyExperienceUpdateID( $id ) {
    echo '<input type="hidden" name="faculty_experience_id" value="'. $id . '">';
  }

  public function addFacultyExperience() {

    if( current_user_can('add_faculty_experience') ) {
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_faculty_experience';

      $check = $wpdb->insert( $table,
        array(
          'FacultyID' => $_POST['faculty_id'],
  			  'EmployerName' => $_POST['employer_name'],
  			  'Designation' => $_POST['designation'],
  			  'FromDate' => $_POST['from_date'],
  			  'ToDate' => $_POST['to_date']
        )
      );

      wp_redirect(admin_url('admin.php?page=acad_faculty_experience'));
    }

    else {
      echo "You are not autorized to add a new Faculty Experience";
    }
  }
  public function deleteFacultyExperiences() {
    if( current_user_can('add_faculty_experience') || current_user_can('view_faculty_experiences') ) {
      global $wpdb;

      $faculty_table = $wpdb->prefix.'acad_faculty';
      $table = $wpdb->prefix.'acad_faculty_experience';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

			echo '<table class="widefat", width="100%">
	  		<thead>
	    		<tr>
	      		<th>Faculty ID</th>
	      		<th>Employer Name</th>
	      		<th>Designation</th>
	      		<th>From Date</th>
	      		<th>To Date</th>
            </tr>
	  		</thead>
	  		<tbody>';
	      	foreach($rows as $row){
            echo "<tr ><td>".$row->FacultyID."</td><td>".$row->EmployerName."</td><td> ".$row->Designation."</td><td>".$row->FromDate."</td><td> ".$row->ToDate."</td></td>\n";
            echo '<td><form method="post"><input type="submit" name="delete" value="Delete"><input type="hidden" name="faculty_experience_id" value="'.$row->FacultyExperienceID.'"></form></td>';

      if ($_POST) {
      global $wpdb;
          echo "Inside";
          $table = $wpdb->prefix . 'acad_faculty_experience';
          $id = $_POST['faculty_experience_id'];
          $res = $wpdb->query("DELETE FROM $table WHERE FacultyExperienceID = ".$id);
           echo "<meta http-equiv='refresh' content='0'>";

          }
        }
      }
    }
  public function viewFacultyExperiences() {
    if( current_user_can('add_faculty_experience') || current_user_can('view_faculty_experiences') ) {
      global $wpdb;

      $faculty_table = $wpdb->prefix.'acad_faculty';
      $table = $wpdb->prefix.'acad_faculty_experience';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

			echo '<table class="widefat", width="100%">
	  		<thead>
	    		<tr>
	      		<th>Faculty ID</th>
	      		<th>Employer Name</th>
	      		<th>Designation</th>
	      		<th>From Date</th>
	      		<th>To Date</th>
            </tr>
	  		</thead>
	  		<tbody>';
	      	foreach($rows as $row){
            echo "<tr ><td>".$row->FacultyID."</td><td>".$row->EmployerName."</td><td> ".$row->Designation."</td><td>".$row->FromDate."</td><td> ".$row->ToDate."</td></tr>\n";
         }
	      echo '</tbody>
			</table>';
    }
  }

  public function updateFacultyExperience() {
    if( current_user_can('update_FacultyExperience') ) {

    }

    }
  }

?>
