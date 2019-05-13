<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api;

class JsApi  {
  public function getProgramForDepartment() {
    global $wpdb;
    $table = $wpdb->prefix . 'acad_program';
    $id = intval( $_POST['value'] );
    $rows = $wpdb->get_results( "SELECT ProgramID, ProgramCode FROM $table WHERE DepartmentID = $id" );

    if( $rows ) {
      echo json_encode( $rows );
      wp_die();
    }
  }

  public function getSemesterForProgram() {
    global $wpdb;
    $table = $wpdb->prefix . 'acad_semester';
    $id = intval( $_POST['value'] );
    $rows = $wpdb->get_results( "SELECT SemesterID, SemesterNumber FROM $table WHERE ProgramID = $id" );

    if( $rows ) {
      echo json_encode( $rows );
      wp_die();
    }
  }

  public function getFacultyForDepartment() {
    global $wpdb;
    $table = $wpdb->prefix . 'acad_faculty';
    $id = intval( $_POST['value'] );
    $rows = $wpdb->get_results( "SELECT FacultyID, FacultyName FROM $table WHERE DepartmentID = $id" );

    if( $rows ) {
      echo json_encode( $rows );
      wp_die();
    }
  }
}

?>
