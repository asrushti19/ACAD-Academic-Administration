<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class FrontEndCallbacks extends BaseController {

  public function displayLoginPage() {
    return do_shortcode('[user_login]');
  }

  public function displayHomePage() {
    return 'Sample site';
  }

  public function displayCoursePage() {
    return do_shortcode('[courses_view]');
  }

  public function displaySemesterRegistration() {
    return do_shortcode('[semester_registration]');
  }

  public function displaySemesterRegistrationApproval() {
    return do_shortcode('[semester_registration_approval]');
  }

  public function displayCoursesAssigned() {
    return do_shortcode('[courses_assigned]');
  }

}

?>
