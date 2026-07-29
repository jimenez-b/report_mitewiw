<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Renderer class for report_mitewiw
 *
 * @package    report_mitewiw
 * @author     Brandon Jimenez <brandon.jimenez@concordia.ca>
 * @copyright  2026 Concordia University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_mitewiw\output;

use plugin_renderer_base;
//use renderable;
use html_writer;

defined('MOODLE_INTERNAL') || die;

/**
 * Renderer class for the reports
 *
 * @package    report_mitewiw
 * @author     Brandon Jimenez <brandon.jimenez@concordia.ca>
 * @copyright  2026 Concordia University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends plugin_renderer_base {
    /**
     *
     * 
     * @return string html for the page
     */
    public function render_overview(array $items, array $attributes) : string {

        $output_left  = html_writer::empty_tag('hr');
        $output_left .= html_writer::tag('p', get_string('introreport', 'report_mitewiw'));
        $output_left .= html_writer::tag('p', get_string('componentsreport', 'report_mitewiw'));
        $output_left .= html_writer::alist($items, $attributes, 'ol');
        $output_left .= html_writer::tag('p', get_string('uncededland', 'report_mitewiw'));
        $output_left .= html_writer::tag('p', get_string('moreinfo', 'report_mitewiw'));

        $src = "https://www.concordia.ca/cunews/main/stories/2024/01/15/office-of-indigenous-directions-offers-new-cree-language-course-to-concordia-faculty-staff-and-students/_jcr_content/parsys/image.img.jpg/1705352125999.jpg";
        $alt = "Cree culture elements";
        $imageatrributes = ['class' => 'img-fluid'];
        $output_right =  html_writer::img($src, $alt, $imageatrributes);

        $left_column  = html_writer::div($output_left, 'col-lg-6');
        $right_column = html_writer::div($output_right, 'col-lg-6');

        $output = html_writer::div($left_column.$right_column, 'row');

        return $output;
    }

}