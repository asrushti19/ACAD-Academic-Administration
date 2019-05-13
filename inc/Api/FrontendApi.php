<?php
/**
 * @package  AcadPlugin
 */
namespace Inc\Api;

class FrontendApi {
  public $custom_shortcodes = array();
  public $custom_pages = array();

  public function register() {
    if( !empty($this->custom_shortcodes) ) {
      $this->addCustomShortcodes();
    }
    if( !empty($this->custom_pages) ) {
			$this->addCustomPages();
		}
  }

  public function setShortcodes(array $custom_shortcodes) {
    $this->custom_shortcodes = array_merge( $this->custom_shortcodes, $custom_shortcodes );

    return $this;
  }

  public function addCustomShortcodes() {
    foreach ( $this->custom_shortcodes as $shortcode => $function ) {
			add_shortcode( apply_filters( "{$shortcode}_shortcode_tag", $shortcode ), $function );
		}
  }
  public function setCustomPages(array $custom_pages) {
		$this->custom_pages = array_merge( $this->custom_pages, $custom_pages);

		return $this;
	}

	public function addCustomPages() {

		foreach ($this->custom_pages as $custom_page ) {
			$page_check = get_page_by_title( $custom_page["post_title"] );
			if( !isset($page_check->ID) ) {
				$page_id = wp_insert_post($custom_page, true);
				var_dump($page_id);
			}
		}
	}


}

?>
