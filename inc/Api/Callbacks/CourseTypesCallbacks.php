<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class CourseTypesCallbacks extends BaseController {
  public function acadCourseTypesSection() {
    echo "<h3> Course Types Creation </h3>";
  }

  public function displayCourseTypesAction() {
    echo '<input type="hidden" name="action" value="add_course_types_action">';
  }

  public function displayCourseTypesName() {
    $value = esc_attr( get_option('course_type_name') );
    echo '<input type="text" class="regular-text" name="course_type_name" value="' . $value . '" placeholder="Course Type">';
  }

  public function addCourseType() {
    echo "Inside";
    if( current_user_can('add_course_types') ) {
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_course_types';

      $check = $wpdb->insert( $table,
        array(
          'CourseTypeName' => $_POST['course_type_name']
        )
      );
      wp_redirect(admin_url('admin.php?page=acad_course_types'));
    }
    else {
      echo "You are not autorized to add a new Course Type";
    }
  }

  public function viewCourseTypes() {
    if( current_user_can('add_course_types') || current_user_can('view_cours_types') ) {
      global $wpdb;
      $table = $wpdb->prefix.'acad_course_types';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

      echo '<table class="widefat", width="100%">
        <thead>
          <tr>
            <th>Course Types</th>
          </tr>
        </thead>
        <tbody>';
          foreach($rows as $row){
            echo "<tr ><td>".$row->CourseTypeName."</td></tr>\n";
          }
        echo '</tbody>
      </table>';
    }

    else {
      echo "You are not authorized to view Course Types.";
    }
  }

}
