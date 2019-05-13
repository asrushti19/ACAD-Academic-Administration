<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class FacultyQualificationCallbacks extends BaseController {
  public function acadFacultyQualificationSection() {
    echo "<h3> FacultyQualification Creation </h3>";
  }

  public function displayFacultyQualificationAction() {
    echo '<input type="hidden" name="action" value="add_faculty_qualification_action">';
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

  public function displayQualificationName() {
    $value = esc_attr( get_option('qualification_level') );
    echo '<input type="text" class="regular-text" name="qualification_name" value="' . $value . '" placeholder="Qualification Name">';
  }

  public function displayCollegeName() {
    $value = esc_attr( get_option('college_name') );
      echo '<input type="text" class="regular-text" name="college_name" value="' . $value . '" placeholder="College Name">';
  }

  public function displayQualificationLevel() {
    $value = esc_attr( get_option('qualification_level') );
    echo '<input type="text" class="regular-text" name="qualification_level" value="' . $value . '" placeholder="Quaification Level">';
  }

  public function displayYearOfPassing() {
    $value = esc_attr( get_option('year_of_passing') );
    echo '<input type="text" class="regular-text" name="year_of_passing" value="' . $value . '" placeholder="Year of Passing">';
  }

  public function displayFacultyQualificationUpdateListAction() {
    echo '<input type="hidden" name="action" value="update_faculty_qualification_getID_action">';
  }

  public function displayFacultyQualificationUpdateID( $id ) {
    echo '<input type="hidden" name="faculty_qualification_id" value="'. $id . '">';
  }

  public function addFacultyQualification() {

    if( current_user_can('add_faculty_qualification') ) {
      global $wpdb;


  		$table = $wpdb->prefix . 'acad_faculty_qualification';

      $check = $wpdb->insert( $table,
        array(
          'FacultyID' => $_POST['faculty_id'],
  			  'QualificationName' => $_POST['qualification_name'],
  			  'CollegeName' => $_POST['college_name'],
  			  'QualificationLevel' => $_POST['qualification_level'],
  			  'YearOfPassing' => $_POST['year_of_passing']
        )
      );

      if( !is_a( $check, WP_ERROR ) ) {
        wp_redirect(admin_url('admin.php?page=acad_faculty_qualification'));
      }
      else {
        echo $check;
      }

      wp_redirect(admin_url('admin.php?page=acad_faculty_qualification'));
    }

    else {
      echo "You are not autorized to add a new FacultyQualification";
    }
  }

  public function viewFacultyQualifications() {
    if( current_user_can('add_faculty_qualification') || current_user_can('view_faculty_qualifications') ) {
      global $wpdb;

      $faculty_table = $wpdb->prefix.'acad_faculty';
      $table = $wpdb->prefix.'acad_faculty_qualification';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

			echo '<table class="widefat", width="100%">
	  		<thead>
	    		<tr>
	      		<th>Faculty ID</th>
	      		<th>Qualification Name</th>
	      		<th>College Name</th>
	      		<th>Qualification Level</th>
	      		<th>Year Of Passing</th>
            </tr>
	  		</thead>
	  		<tbody>';
	      	foreach($rows as $row){
            echo "<tr ><td>".$row->FacultyID."</td><td>".$row->QualificationName."</td><td> ".$row->CollegeName."</td><td>".$row->QualificationLevel."</td><td> ".$row->YearOfPassing."</td></tr>\n";
         }
	      echo '</tbody>
			</table>';
    }
  }

  public function updateFacultyQualification() {
    if( current_user_can('update_FacultyQualification') ) {

    }

    }
  }

?>
