<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Pages;

use Inc\Api\FrontendApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\FrontEndCallbacks;
use Inc\Shortcodes\FrontEndShortcodes;

class FrontEnd extends BaseController {
  public $settings;
  public $frontend_callbacks;
  public $shortcodes;

  public function register() {
    $this->settings = new FrontendApi();
    $this->frontend_callbacks = new FrontEndCallbacks();
    $this->shortcodes = new FrontEndShortcodes();

    $this->setShortcodes();
    $this->setCustomPages();

    $this->settings->register();
  }

  public function setShortcodes() {
    $args = array(
      'user_login' => array( $this->shortcodes, 'userLogin' ),
      'courses_view' => array( $this->shortcodes, 'viewCourses' ),
      'semester_registration' => array( $this->shortcodes, 'semesterRegistration' ),
      'semester_registration_approval' => array( $this->shortcodes, 'semesterRegistrationApproval' ),
      'courses_assigned' => array( $this->shortcodes, 'coursesAssigned' )
    );

    $this->settings->setShortcodes( $args );
  }

  public function setCustomPages() {
    $page_guid = site_url();

    $login_content = $this->frontend_callbacks->displayLoginPage();
    $content = $this->frontend_callbacks->displayHomePage();
    $course_contents = $this->frontend_callbacks->displayCoursePage();
    $semester_registration_contents = $this->frontend_callbacks->displaySemesterRegistration();
    $semester_registration_approval_contents = $this->frontend_callbacks->displaySemesterRegistrationApproval();
    $courses_assigned_contents = $this->frontend_callbacks->displayCoursesAssigned();

    $args = array(
      array(
        'post_title' => 'ACAD Login',
        'post_type' => 'page',
        'post_name' => 'ACAD Login',
        'post_content' => $login_content,
        'post_status' => 'publish',
        'post_author' => 1,
        'guid' => $page_guid
      ),
      array(
        'post_title' => 'Home',
        'post_type' => 'page',
        'post_name' => 'ACAD Home',
        'post_content' => $content,
        'post_status' => 'publish',
        'post_author' => 1,
        'guid' => $page_guid
      ),
      array(
        'post_title' => 'Courses',
        'post_type' =>'page',
        'post_name' => 'ACAD Courses',
        'post_content' => $course_contents,
        'post_status' => 'publish',
        'post_author' => 1,
        'guid' => $page_guid
      ),
      array(
        'post_title' => 'Semester Registration',
        'post_type' =>'page',
        'post_name' => 'ACAD Semester Registration',
        'post_content' => $semester_registration_contents,
        'post_status' => 'publish',
        'post_author' => 1,
        'guid' => $page_guid
      ),
      array(
        'post_title' => 'Semester Registration Approval',
        'post_type' =>'page',
        'post_name' => 'ACAD Semester Registration Approval',
        'post_content' => $semester_registration_approval_contents,
        'post_status' => 'publish',
        'post_author' => 1,
        'guid' => $page_guid
      ),
      array(
        'post_title' => 'Courses Assigned',
        'post_type' =>'page',
        'post_name' => 'ACAD Courses Assigned',
        'post_content' => $courses_assigned_contents,
        'post_status' => 'publish',
        'post_author' => 1,
        'guid' => $page_guid
      )
    );

    $this->settings->setCustomPages( $args );
  }


}
?>
