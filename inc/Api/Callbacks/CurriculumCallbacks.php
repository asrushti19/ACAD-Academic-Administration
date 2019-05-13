<?php
/**
 * @package  AcadPlugin
 */

namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class CurriculumCallbacks extends BaseController {
  public function acadCurriculumSection() {
    echo "<h3> Curriculum Creation </h3>";
  }

  public function displayCurriculumAction() {
    echo '<input type="hidden" name="action" value="add_curriculum_action">';
  }

  public function displayCurriculumCode() {
    $value = esc_attr( get_option('curriculum_code') );
    echo '<input type="text" class="regular-text" name="curriculum_code" value="' . $value . '" placeholder="Curriculum Code">';
  }

  public function displayTotalCredits() {
    $value = esc_attr( get_option('total_credits') );
    echo '<input type="text" class="regular-text" name="total_credits" value="' . $value . '" placeholder="Total credits">';
  }

  public function addCurriculum() {
    if( current_user_can('add_curriculum') ) {
      global $wpdb;
  		$table = $wpdb->prefix . 'acad_curriculum';

      $check = $wpdb->insert( $table,
        array(
          'CurriculumCode' => $_POST['curriculum_code'],
  			  'TotalCredits' => $_POST['total_credits']
        )
      );

      wp_redirect(admin_url('admin.php?page=acad_curriculum'));
    }
    else {
      echo "You are not authorized to add a new curriculum";
    }
  }

  public function viewCurriculums() {
    if( current_user_can('add_curriculum') || current_user_can('view_curriculum') ) {
      global $wpdb;
      $table = $wpdb->prefix.'acad_curriculum';
      $rows = $wpdb->get_results( "SELECT * FROM $table" );

      echo '<table class="widefat", width="100%">
        <thead>
          <tr>
            <th>Code</th>
            <th>Total Credits</th>
            </tr>
        </thead>
        <tbody>';
          foreach($rows as $row){
            echo "<tr ><td>".$row->CurriculumCode."</td><td>".$row->TotalCredits. "</td></tr>\n";
          }
        echo '</tbody>
      </table>';
    }
  }
}
