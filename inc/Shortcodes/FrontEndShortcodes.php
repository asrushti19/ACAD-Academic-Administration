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

        /*
        Check whether the student has already registered for the current semester.
        A student can be in  a Semester only once, unless detained. So check for any previous entry with same StudnetEnrollmentNumber and SemesterID with IsBacklog = 0 and IsDeained = 0
        */
        $enrollment_table = $wpdb->prefix . 'acad_enrollment';
        $res = $wpdb->get_results( "SELECT EnrollmentID from $enrollment_table WHERE StudentEnrollmentNumber = ".$studentEnrollmentNumber." AND SemesterID = ".$semester[0]->SemesterID ." AND IsDetained = 0 AND IsBacklog = 0" );

        if( $res ) {
          echo "You have already registered!";
          return;
        }

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

  public function semesterRegistrationApproval() {

    $current_user = wp_get_current_user();
    $faculty_id = $current_user->user_login;
    global $wpdb;

    if($_POST) {

      $enrollment_table = $wpdb->prefix . 'acad_enrollment';
      $reg_table = $wpdb->prefix . 'acad_semester_registration';
      $student_table = $wpdb->prefix . 'acad_student';

      /*
      Approve registrations of one or more students.
      Set semesterRegistration->RegistrationStatus = Approved and enrollment -> IsCurrentlyEnrolled = true
      */
      if( $_POST['Approve'] ) {
        foreach ($_POST as $record => $value) {
          if( $record != "Approve") {
            $wpdb->query( "UPDATE $enrollment_table SET IsApproved = 1 WHERE StudentEnrollmentNumber = ". $value );
            $wpdb->query( "UPDATE $reg_table SET RegistrationStatus = 'Approved' WHERE StudentEnrollmentNumber = ". $value );
          }
        }
        echo "Approved successfully";
      }

      /*
      View details of a single student's registration
      */
      if( $_POST['View'] ) {
        foreach ($_POST as $student => $value) {
          if( $student != "View" ) {
            $id = $value;
            $rows = $wpdb->get_results( "SELECT FirstName, MiddleName, LastName, SemesterID, CourseID, IsCurrentlyEnrolled, IsApproved, IsDetained, IsBacklog, CourseGrade, CreditsTaken FROM $enrollment_table, $reg_table, $student_table WHERE $enrollment_table.StudentEnrollmentNumber = ". $value . " AND $reg_table.StudentEnrollmentNumber = ". $value ." AND $student_table.StudentEnrollmentNumber = ". $value );

            $course_ids = array();
            foreach ($rows as $row => $value) {
              array_push( $course_ids, $value->CourseID );
            }

            $format = implode(',', $course_ids);

            //get course names from course ids
            $course_table = $wpdb->prefix . 'acad_course';
            $courses = $wpdb->get_results( "SELECT CourseName, CourseCredits FROM $course_table WHERE CourseID IN ($format)" );

            echo '<table border=0><tr><th>Student Enrollment Number : </th><td>'.$id.'</td></tr><tr><th>Student Name:</th><td>'.$rows[0]->FirstName.' '. $rows[0]->MiddleName.' '. $rows[0]->LastName .'</td></tr></table>';

            //Display all the details in a table
            echo '<table border = 0><th>Course Name</th><th>Course Credits</th><th>IsBacklog</th><th>IsDetained</th></tr>';

            foreach ($courses as $course => $v) {
              echo '<tr><td>'. $v->CourseName.'</td><td>'. $v->CourseCredits.'</td><td>'.$rows[0]->IsBacklog.'</td><td>' . $rows[0]->IsDetained.'</td></tr>';
            }

            echo '<tr></table><table border = 0><th>Credits Taken : </th><td>'. $rows[0]->CreditsTaken.'</td></table></tr><tr><td><form method="post"><input type="hidden" name="'.$id.'" value="'.$id.'"><input type="submit" name="Approve" value="Approve"></form></td></tr></table>';
          }
        }
      }
    }
    else {
      //show a list of classes
      $mappings_table = $wpdb->prefix . 'acad_faculty_registration_mapping';
      $mappings = $wpdb->get_results( "SELECT FacultyRegistrationMappingID FROM $mappings_table WHERE FacultyID = $faculty_id" );

      $ids_array = array();
      foreach ($mappings as $mapping => $value) {
        array_push( $ids_array, intval($value->FacultyRegistrationMappingID) );
      }

      $format = implode(',', $ids_array);
      $reg_table = $wpdb->prefix . 'acad_semester_registration';
      $registrations = $wpdb->get_results( "SELECT * FROM $reg_table WHERE FacultyRegistrationMappingID IN ($format)" );

      echo '<form method="post"><table border="0"><tr><th>Student Enrollment Number</th><th>Student Name</th><th>Department</th><th>Total Credits</th><th>Backlogs</th><th>Detained</th><th>Status</th><th>Approve</th><th>View</th></tr>';


      $enrollment_table = $wpdb->prefix . 'acad_enrollment';
      $department_table = $wpdb->prefix . 'acad_department';
      $program_table = $wpdb->prefix .'acad_program';
      $student_table = $wpdb->prefix . 'acad_student';

      foreach ($registrations as $registration => $value) {
        $backlogs = 0;
        $detained = 0;

        //get all the courses that the student has registered for
        $enrollments = $wpdb->get_results( "SELECT IsBacklog, IsDetained FROM $enrollment_table WHERE StudentEnrollmentNumber = ". $value->StudentEnrollmentNumber );

        $student_details = $wpdb->get_results( "SELECT FirstName, MiddleName, LastName, $student_table.ProgramID, DepartmentName FROM $student_table, $department_table, $program_table WHERE $student_table.StudentEnrollmentNumber = ". $value->StudentEnrollmentNumber. " AND $student_table.ProgramID = $program_table.ProgramID AND $program_table.DepartmentID = $department_table.DepartmentID" );

        //check for any backlogs or detention in all the courses
        foreach ($enrollments as $enrollment => $val) {
          if( $val->IsBacklog == 1 )
            $backlogs += 1;
          if( $val->IsDetained == 1)
            $detained ="Yes";
        }

        /*
        Putting this constraint enables us to get only fresh records from this semester for approval.
        */

        if($value->RegistrationStatus == "Pending") {
          echo '<tr><form method="post"><td>'. $value->StudentEnrollmentNumber. '</td><td>'.$student_details[0]->FirstName .' '.$student_details[0]->MiddleName.' '.$student_details[0]->LastName.'</td><td>'.$student_details[0]->DepartmentName.'</td><td>'.$value->CreditsTaken .'</td><td>'. $backlogs .'</td><td>' .$detained. '</td><td>'.$value->RegistrationStatus.'</td><td><input type="checkbox" name="'.$value->StudentEnrollmentNumber.'" value="'.$value->StudentEnrollmentNumber.'"></td><td><input type="submit" name="View" value="View"><input type="hidden" name="'.$value->StudentEnrollmentNumber.'" value="'.$value->StudentEnrollmentNumber.'"></td></form></tr>';
        }
      }

      echo '<tr><td><input type="submit" name="Approve" value="Approve"></td></tr></table></form>';
    }
  }

  /*
  Display the details of all courses assigned to the faculty who is logged in currently.
  */
  public function coursesAssigned() {
    global $wpdb;

    $current_user = wp_get_current_user();
    $faculty_id = $current_user->user_login;

    $mappings_table = $wpdb->prefix . 'acad_faculty_course_mapping';
    $course_table = $wpdb->prefix .'acad_course';
    $course_types_table = $wpdb->prefix . 'acad_course_types';
    $department_table = $wpdb->prefix . 'acad_department';
    $curriculum_table = $wpdb->prefix . 'acad_curriculum';
    $course_curriculum_mapping_table = $wpdb->prefix . 'acad_course_curriculum_mapping';

    $data = $wpdb->get_results( "SELECT $course_table.CourseID, DepartmentName, CourseTypeName, CourseName, CourseCode, CourseAbbreviation, SyllabusCode, IsTheory, SemesterNumber, CourseCredits FROM $course_table LEFT OUTER JOIN $department_table ON $department_table.DepartmentID = $course_table.DepartmentID LEFT OUTER JOIN $course_types_table ON $course_types_table.CourseTypeID = $course_table.CourseTypeID LEFT OUTER JOIN $course_curriculum_mapping_table ON $course_curriculum_mapping_table.CourseID = $course_table.CourseID LEFT OUTER JOIN $mappings_table ON $course_table.CourseID = $mappings_table.CourseID WHERE $mappings_table.FacultyID = ". $faculty_id );

    echo '<table border="0"><tr><th>Course Name</th><th>Course Type</th><th>Deparment Name</th><th>Course Code</th><th>CurriculumCode</th><th>Semester Number</th></tr>';

    foreach ($data as $mapping => $value) {

      //get Curriculum Code for each course
      $curriculum = $wpdb->get_results( "SELECT CurriculumCode FROM $curriculum_table, $course_curriculum_mapping_table WHERE $curriculum_table.CurriculumID = $course_curriculum_mapping_table.CurriculumID AND $course_curriculum_mapping_table.CourseID = ". intval( $value->CourseID ) );

      echo '<tr><td>'.$value->CourseName.'</td><td>'.$value->CourseTypeName.'</td><td>'.$value->DepartmentName.'</td><td>'.$value->CourseCode.'</td><td>'.$curriculum[0]->CurriculumCode.'</td><td>'.$value->SemesterNumber.'</td></tr>';
    }

    echo '</table>';
  }

  /*
  Display the details of students enrolled for all courses taken by the logged in faculty
  */
  public function enrolledStudents() {
    global $wpdb;

    //get the id of the currently logged in user
    $current_user = wp_get_current_user();
    $faculty_id = $current_user->user_login;

    //Populate a dropdown for selecting out of courses
    $mappings_table = $wpdb->prefix . 'acad_faculty_course_mapping';
    $course_table = $wpdb->prefix. 'acad_course';

    $mappings = $wpdb->get_results( "SELECT $course_table.CourseID, CourseName FROM $course_table LEFT OUTER JOIN $mappings_table ON $course_table.CourseID = $mappings_table.CourseID WHERE $mappings_table.FacultyID = ".$faculty_id );

    /*
    get the SemesterID of the current Semester and pass it as a hidden field.
    */
    $semester_table = $wpdb->prefix . 'acad_semester';
    //get the semester IDs of all the current semesters, irrespesctive of their program.
    $semester_ids = $wpdb->get_results( "SELECT SemesterID FROM $semester_table WHERE IsCurrent = 1" );

    //Make an integer array to send to the PHP file through JQuery
    $ids = array();
    foreach ($semester_ids as $id => $value) {
      array_push( $ids, intval($value->SemesterID));
    }

    //pass each semester ID as the value of a hidden field
    echo '<table border="0"><tr><th>Course : </th><td><form><input type="hidden" name="action" value="get_enrolled_students_for_course">';
    foreach ($semester_ids as $id => $value) {
      echo '<input type="hidden" class="course_enrolled_students_select_class" name="semester_ids[]" value="'.$value->SemesterID.'">';
    }

    echo '<select id="select_course_enrolled_students">';
    foreach ($mappings as $mapping => $value) {
      echo '<option value="'.$value->CourseID.'">'.$value->CourseName.'</option>';
    }
    echo '</select></td></tr></table>';

    /*
    Show a table contaning all students from all courses that the faculty is mapped to.
    JQuery code will hide this table and display this hidden table which will be filled based on the value in the select field.
    */

    echo '<table border="0" name="enrolled_students_for_course_table" id="enrolled_students_for_course_table" style="visibility: hidden"><tr><th>Student Enrollment Number</th><th>Student Name</th></tr></table>';

    echo '</form>';

  }
/*Will display the personal profile of students*/
  public function studentPersonalProfile(){
    global $wpdb;

    $current_user = wp_get_current_user();
    $student_enrollment_number = $current_user->user_login;
    $student_table = $wpdb->prefix . 'acad_student';

    if($_POST) {

      //updating goes here
    }

    else {
      $student = $wpdb->get_results( "SELECT * FROM $student_table WHERE StudentEnrollmentNumber = " .$student_enrollment_number );

      echo '<form method="post"><table border="0"><tr><td> StudentEnrollmentNumber: </td><td><label>'.$student[0]->StudentEnrollmentNumber.' </label></td>
      <td> First Name : </td> <td><input type ="text" name = "first_name" value = "' .$student[0]->FirstName.'"></td></tr>
      <td> Middle Name : </td> <td><input type ="text" name = "middle_name" value = "' .$student[0]->MiddleName.'"></td>
      <td> Last Name : </td> <td><input type ="text" name = "last_name" value = "' .$student[0]->LastName.'"></td></tr>
      <td> Mothers Name : </td> <td><input type ="text" name = "mother_name" value = "' .$student[0]->MotherName.'"></td>
      <td> Gender : </td> <td><input type ="text" name = "gender" value = "' .$student[0]->Gender.'"></td>
      <tr><td> Date of Birth : </td> <td><label>' .$student[0]->Gender.'</label></td>
      <td> Blood Group : </td> <td><label>' .$student[0]->BloodGroup.'</label></td></tr>
      <tr><td><b> Temporary Addresss Details : </b></td></tr>
      <td> Address Line 1 : </td> <td><input type ="text" name = "temp_addr_line_1" value = "' .$student[0]->TempAddrLine1.'"></td></tr>
      <td> Taluka : </td> <td><input type ="text" name = "temp_addr_taluka" value = "' .$student[0]->TempAddrTaluka.'"></td>
      <td> District : </td> <td><input type ="text" name = "temp_addr_district" value = "' .$student[0]->TempAddrDistrict.'"></td></tr>
      <td> Country : </td> <td><input type ="text" name = "temp_addr_country" value = "' .$student[0]->TempAddrCountry.'"></td>
      <td> State : </td> <td><input type ="text" name = "temp_addr_state" value = "' .$student[0]->TempAddrState.'"></td></tr>
      <td> Pincode : </td> <td><input type ="text" name = "temp_addr_pincode" value = "' .$student[0]->TempAddrPostalCode.'"></td>
      <tr><td><b> Permanent Addresss Details : </b></td></tr>
      <td> Address Line 1 : </td> <td><input type ="text" name = "perm_addr_line_1" value = "' .$student[0]->PermAddrLine1.'"></td></tr>
      <td> Taluka : </td> <td><input type ="text" name = "perm_addr_taluka" value = "' .$student[0]->PermAddrTaluka.'"></td>
      <td> District : </td> <td><input type ="text" name = "perm_addr_district" value = "' .$student[0]->PermAddrDistrict.'"></td></tr>
      <td> Country : </td> <td><input type ="text" name = "perm_addr_country" value = "' .$student[0]->PermAddrCountry.'"></td>
      <td> State : </td> <td><input type ="text" name = "perm_addr_state" value = "' .$student[0]->PermAddrState.'"></td></tr>
      <td> Pincode : </td> <td><input type ="text" name = "perm_addr_pincode" value = "' .$student[0]->PermAddrPincode.'"></td>
      <tr><td><b> Contact Details : </b></td></tr>
      <td> Permanent Address Contact : </td> <td><input type ="text" name = "perm_addr_contact_no" value = "' .$student[0]->PermAddrContactNo.'"></td></tr>
      <td> Personal Contact : </td> <td><input type ="text" name = "personal_contact_no" value = "' .$student[0]->PersonalContactNo.'"></td>
      <td> Emergency Contact : </td> <td><input type ="text" name = "emergency_contact_no" value = "' .$student[0]->EmergencyContactNo.'"></td></tr>
      <tr><td><b> Email Address Details : </b></td></tr>
      <td> College Email : </td> <td><input type ="text" name = "college_email" value = "' .$student[0]->CollegeEmail.'"></td>
      <td> Personal Mail : </td> <td><input type ="text" name = "personal_email" value = "' .$student[0]->PersonalEmail.'"></td></tr>
      <tr><td><b> Caste Details : </b></td></tr>
      <td> Caste : </td> <td><input type ="text" name = "caste" value = "' .$student[0]->Caste.'"></td>
      <td> Religion : </td> <td><input type ="text" name = "religion" value = "' .$student[0]->Religion.'"></td></tr>
      <td> Caste Category : </td> <td><input type ="text" name = "caste_category" value = "' .$student[0]->CasteCategory.'"></td></tr>
      <td> Is Handicap : </td> <td><input type ="text" name = "is_handicapped" value = "' .$student[0]->IsHandicapped.'"></td>
      <tr><td><b> Adhaar Details : </b></td>
      <td> Addhar ID : </td> <td><label>' .$student[0]->AadharID.'</label></td></tr>
      <td> Photo : </td> <td><input type ="text" name = "photo" value = "' .$student[0]->Photo.'"></td></tr>
      <tr><td><b> Bank Account Details Details : </b></td></tr>
      <td> Bank Account Number : </td> <td><input type ="text" name = "bank_account_number" value = "' .$student[0]->BankAccountNumber.'"></td>
      <td> Bank Name : </td> <td><input type ="text" name = "bank_name" value = "' .$student[0]->BankName.'"></td></tr>
      <td> Bank Branch Name : </td> <td><input type ="text" name = "bank_branch_name" value = "' .$student[0]->BankBranchName.'"></td>
      <td> Bank Branch Code : </td> <td><input type ="text" name = "bank_branch_code" value = "' .$student[0]->BankBranchCode.'"></td>  ';




      echo '</tr></table></form>';

    }


  }

}


 ?>
