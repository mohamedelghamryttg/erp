<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Breadcrumbs
{
	private $breadcrumbs = array();
	private $separator = ' &nbsp;  /  &nbsp; ';
	private $start = '<div id="breadcrumb" class="breadcrumb">' . '<li class="breadcrumb-item">';
	private $end = '</li></div>';
	public function __construct($params = array())
	{
		if (count($params) > 0) {
			$this->initialize($params);
		}
	}

	private function initialize($params = array())
	{
		if (count($params) > 0) {
			foreach ($params as $key => $val) {
				if (isset($this->{'_' . $key})) {
					$this->{'_' . $key} = $val;
				}
			}
		}
	}
	function add($title, $href)
	{
		if (!$title or !$href)
			return;
		$this->breadcrumbs[] = array('title' => $title, 'href' => $href);
	}

	function output()
	{
		if ($this->breadcrumbs) {
			$output = $this->start;
			foreach ($this->breadcrumbs as $key => $crumb) {

				if (array_key_last($this->breadcrumbs) == $key) {
					if ($key) {
						$output .= $this->separator;
					}
					$output .= '<span>' . $crumb['title'] . '</span>';
				} else {
					$output .= '<a href="' . $crumb['href'] . '" class="breadcrumb-item">' . $crumb['title'] . '</a>';
				}
			}
			return $output . $this->end . PHP_EOL;
		}
		return '';
	}
}