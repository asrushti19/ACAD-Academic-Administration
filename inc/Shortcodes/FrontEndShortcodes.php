<?php
/**
 * @package  AcadPlugin
 */

namespace Inc\Shortcodes;

use Inc\Api\Callbacks\CourseCallbacks;
use Inc\Api\Callbacks\SemesterCallbacks;

class FrontEndShortcodes {

  public function userLogin() {
    global $user_id;
    if( !$user_id ){
      echo "Inside";
      if( $_POST["mis"] != "" ) {
        echo "Inside";
        $creds = array(
          'user_login' => $_POST["mis"],
          'user_password' => $_POST['passwd']
        );

        $user_info = wp_signon($creds, false);

        if(!is_a($user_info, 'WP_Error')) {
          echo "inside";
          $username = $_POST["mis"];
          wp_set_current_user($user->ID, $username);
          wp_set_auth_cookie($user->ID, true, false);
          do_action('wp_login', $username);
          echo "<script> window.location='".site_url()."'</script>";
        } else {
          echo '(ERROR, Error authenticating:'  . $user_info->get_error_message($user_info->get_error_code());
        }

        $user_info = wp_get_current_user();
      }
      else {
        echo '<table border=0><form method="post"><tr><td>MIS</td><td><input type="text" name="mis" required></td></tr><tr><td>Password</td><td><input type="password" name="passwd" required></td></tr><tr><td><input type="submit" value="Submit"></td>';
      }
    }
  }

  public function viewCourses() {
    $courses = new CourseCallbacks();
    $courses->viewCourses();
  }

  public function semesterRegistration() {
    if( current_user_can('enroll_course') ) {

      //get the details of the currently logged in student
      $current_user = wp_get_current_user();
      $studentEnrollmentNumber = $current_user->user_login;

      if( $_POST ) {
        //Insert data into database

        global $wpdb;

        $semester_id = $_POST["SemesterID"];
        $semester_number = $_POST["SemesterNumber"];

        $total_credits = 0;

        //get the courseIDs from POST data and save in the database
        foreach ($_POST as $course => $id) {
          if( $course != "submit" && $course != "SemesterID" && $course != "SemesterNumber" && $course != "ProgramID" && $course != "DepartmentID" && $course != "CourseCredits" ) {

            $is_detained = 0;
            $is_backlog = 0;
            $course_grade = 0;

            $id_credits = explode("_", $id);
            $total_credits += $id_credits[1];

            $insertsql = "INSERT INTO {$wpdb->prefix}acad_enrollment
            (StudentEnrollmentNumber, SemesterID, CourseID, IsCurrentlyEnrolled, IsApproved, IsDetained, IsBacklog, CourseGrade) VALUES ($studentEnrollmentNumber, $semester_id, $id_credits[0], 1, 0, $is_detained, $is_backlog, $course_grade );";
            $wpdb->query($insertsql);
          }
        }
        /*
        insert registration data into acad_student_registration
        */

        //get the FacultyRegistrationMappingID
        $faculty_table = $wpdb->prefix . 'acad_faculty_registration_mapping';
        $mapping = $wpdb->get_results( "SELECT FacultyRegistrationMappingID FROM $faculty_table WHERE DepartmentID = ". $_POST['DepartmentID']. " AND ProgramID = ". $_POST['ProgramID']. " AND SemesterID = ". $semester_id );

        $current_date =  date("Y-m-d");
        $map_id = intval( $mapping[0]->FacultyRegistrationMappingID);

        $insertsql = "INSERT INTO {$wpdb->prefix}acad_semester_registration (FacultyRegistrationMappingID, StudentEnrollmentNumber, RegistrationDate, RegistrationStatus, CreditsTaken) VALUES ( $map_id, $studentEnrollmentNumber, '$current_date', 'Pending', $total_credits); ";
        $wpdb->query($insertsql);

        echo "Registration saved successfully!";
      }
      else {
        //display registration form
        global $wpdb;
        /*
        Select the program associated with the department of the currently logged in user
        */

        //get current program from student
        $student_table = $wpdb->prefix . 'acad_student';
        $program = $wpdb->get_results( "SELECT ProgramID FROM $student_table WHERE StudentEnrollmentNumber = $studentEnrollmentNumber" );

        if( $program[0]->ProgramID ) {
          //get the curriculum associated with the program
          $program_table = $wpdb->prefix . 'acad_program';

          $curriculum = $wpdb->get_results( "SELECT CurriculumID, DepartmentID FROM $program_table WHERE ProgramID =" .  $program[0]->ProgramID );

          //get active semester for that program.
          $semester_table = $wpdb->prefix . 'acad_semester';
          $semester = $wpdb->get_results( "SELECT SemesterID, SemesterNumber FROM $semester_table WHERE ProgramID = " . $program[0]->ProgramID  );

          if( $semester[0]->SemesterNumber && $curriculum[0]->CurriculumID ) {

            //get the courses associated with this student from the CourseCurriculumMapping table
            $course_curriculum_mapping_table = $wpdb->prefix . 'acad_course_curriculum_mapping';
            $course_ids = $wpdb->get_results( "SELECT CourseID FROM $course_curriculum_mapping_table WHERE CurriculumID = " . $curriculum[0]->CurriculumID ." AND SemesterNumber = " . $semester[0]->SemesterNumber );

            if( $course_ids[0]->CourseID ) {
              $ids = array();
              foreach ($course_ids as $course_id) {
                array_push($ids, abs( intval( $course_id->CourseID ) ));
              }

              $format = implode(',', $ids);

              //get courses from course table
              $course_table = $wpdb->prefix . 'acad_course';
              $courses = $wpdb->get_results( "SELECT * FROM $course_table WHERE CourseID IN ($format)" );

              if( !isset( $courses ) ) {
                echo "No courses found";
                return;
              }

              $course_types_table = $wpdb->prefix . 'acad_course_types';
              $course_types = $wpdb->get_results( "SELECT * FROM $course_types_table" );

              if(!$course_types) {
                echo "error in getting course types";
                return;
              }

              echo '<table border=1>';

              foreach( $course_types as $course_type) {

                echo '<table border=0><thead><b>'. $course_type->CourseTypeName.'</b></thead><form method="post"><table border=0><th>Course Name</th><th>Course Credits</th><th>Select</th>';
                foreach ($courses as $course => $value ) {
                  if($value->CourseTypeID == $course_type->CourseTypeID) {
                    echo '<tr><td>';
                    print_r($value->CourseName);
                    echo '</td>';
                    echo '<td><label>'.$value->CourseCredits.'</label></td><td><input type="checkbox" name="'. $value->CourseName .'"value="'. $value->CourseID.'_'.$value->CourseCredits.'"></td>';
                  }

                }
                echo '</table>';
              }
              echo '<input type="hidden" name="SemesterID" value="'. $semester[0]->SemesterID .'">';
              echo '<input type="hidden" name="SemesterNumber" value="'. $semester[0]->SemesterNumber .'">';
              echo '<input type="hidden" name="DepartmentID" value="'. $curriculum[0]->DepartmentID .'">';
              echo '<input type="hidden" name="ProgramID" value="'. $program[0]->ProgramID .'">';
              echo '<input type="submit" value="Save Changes" name="submit">';
              $flag = 1;
              echo '</form></table>';
            }
          }
        }
      }
    }

    else {
      echo "You are not authorized to view this page";
    }
  }

  public function semesterRegistrationApproval() {
    if( current_user_can('approve_semester_registration') ) {
        echo "Inside functionn ";
    }
    else {
      echo "You are not authorized to view this page";
    }
  }

}


 ?>
