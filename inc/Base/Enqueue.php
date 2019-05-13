<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Base;

use \Inc\Base\BaseController;
use \Inc\Api\JsApi;

/**
*
*/
class Enqueue extends BaseController
{
	public $js_callbacks;

	public function register() {
		$this->js_callbacks = new JsApi();
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'wp_ajax_get_program_for_department', array( $this->js_callbacks, 'getProgramForDepartment') );
		add_action( 'wp_ajax_get_semester_for_program', array( $this->js_callbacks, 'getSemesterForProgram') );
		add_action( 'wp_ajax_get_faculty_for_department', array( $this->js_callbacks, 'getFacultyForDepartment') );
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
}
