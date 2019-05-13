<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class AdminCallbacks extends BaseController
{
	public function adminDashboard()
	{
		return require_once( "$this->plugin_path/templates/admin.php" );
	}

	public function adminDepartment()
	{
		return require_once( "$this->plugin_path/templates/department.php" );
	}

	public function adminCourseTypes()
	{
		return require_once( "$this->plugin_path/templates/course_types.php" );
	}

	public function adminCourse()
	{
		return require_once( "$this->plugin_path/templates/course.php" );
	}

	public function adminCurriculum()
	{
		return require_once( "$this->plugin_path/templates/curriculum.php" );
	}

	public function adminCourseCurriculumMapping() {
		return require_once( "$this->plugin_path/templates/course_curriculum_mapping.php" );
	}

	public function adminProgram() {
		return require_once( "$this->plugin_path/templates/program.php" );
	}

	public function adminSemester() {
		return require_once( "$this->plugin_path/templates/semester.php" );
	}

	public function adminFaculty() {
		return require_once( "$this->plugin_path/templates/faculty.php" );
	}

	public function adminFacultyQualification() {
		return require_once( "$this->plugin_path/templates/faculty_qualification.php" );
	}

	public function adminFacultyExperience() {
		return require_once( "$this->plugin_path/templates/faculty_experience.php" );
	}

	public function adminFacultyRegistrationMapping() {
		return require_once( "$this->plugin_path/templates/faculty_registration_mapping.php" );
	}

	public function adminFacultyRequestTypes()
	{
		return require_once( "$this->plugin_path/templates/faculty_request_types.php" );
	}

	public function adminFacultyRequests()
	{
		return require_once( "$this->plugin_path/templates/faculty_requests.php" );
	}

	public function adminFacultyResponses()
	{
		return require_once( "$this->plugin_path/templates/faculty_responses.php" );
	}

	public function adminStudent()
	{
		return require_once( "$this->plugin_path/templates/student.php" );
	}

	public function adminStudentAdmission()
	{
		return require_once( "$this->plugin_path/templates/student_admission.php" );
	}

	public function adminStudentRequests()
	{
		return require_once( "$this->plugin_path/templates/student_requests.php" );
	}

	public function adminStudentRequestTypes()
	{
		return require_once( "$this->plugin_path/templates/student_request_types.php" );
	}

	public function adminStudentResponses()
	{
		return require_once( "$this->plugin_path/templates/student_responses.php" );
	}

	public function adminExamType()
	{
		return require_once( "$this->plugin_path/templates/exam_type.php" );
	}

	public function adminExam()
	{
		return require_once( "$this->plugin_path/templates/exam.php" );
	}

	public function adminLogTable()
	{
		return require_once( "$this->plugin_path/templates/log_table.php" );
	}

	public function adminFeedbackCategory()
	{
		return require_once( "$this->plugin_path/templates/feedback_category.php" );
	}

	public function acadOptionsGroup( $input )
	{
		return $input;
	}

	public function acadAdminSection()
	{
		echo 'Check this beautiful section!';
	}

	public function acadTextExample()
	{
		$value = esc_attr( get_option( 'text_example' ) );
		echo '<input type="text" class="regular-text" name="text_example" value="' . $value . '" placeholder="Write Something Here!">';
	}

	public function acadFirstName()
	{
		$value = esc_attr( get_option( 'first_name' ) );
		echo '<input type="text" class="regular-text" name="first_name" value="' . $value . '" placeholder="Write your First Name">';
	}
}
