<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Base;

use \Inc\Base\BaseController;
use \Inc\Api\JsApi;
use \Inc\Api\FrontEndJSApi;

/**
*
*/
class Enqueue extends BaseController
{
	public $js_callbacks;
	public $frontend_js_callbacks;

	public function register() {
		$this->js_callbacks = new JsApi();
		$this->frontend_js_callbacks = new FrontEndJSApi();

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'wp_enqueue_scripts' , array( $this, 'frontEndEnqueue' ) );

		add_action( 'wp_ajax_get_program_for_department', array( $this->js_callbacks, 'getProgramForDepartment') );
		add_action( 'wp_ajax_get_semester_for_program', array( $this->js_callbacks, 'getSemesterForProgram') );
		add_action( 'wp_ajax_get_faculty_for_department', array( $this->js_callbacks, 'getFacultyForDepartment') );

		add_action( 'wp_ajax_get_enrolled_students_for_course', array($this->frontend_js_callbacks, 'getEnrolledStudentsForCourse') );

	}

	function enqueue() {
		//register dependency of scripts that use jquery
		wp_enqueue_script( 'ajax-script', $this->plugin_url . 'assets/jquery_selects.js', array( 'jquery' ) );
		wp_localize_script( 'ajax-script', 'ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		// enqueue all our scripts
		wp_enqueue_style( 'mypluginstyle', $this->plugin_url . 'assets/mystyle.css' );
		wp_enqueue_script( 'mypluginscript', $this->plugin_url . 'assets/myscript.js' );
	}

	function frontEndEnqueue() {
		wp_enqueue_script( 'frontend-ajax-script', $this->plugin_url . 'assets/front_end_selects.js', array( 'jquery' ) );
		wp_localize_script( 'frontend-ajax-script', 'ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}
}
