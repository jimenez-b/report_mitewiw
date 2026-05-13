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
 * Helper class for Mitewiw report
 *
 * @package    report_mitewiw
 * @author     Brandon Jimenez <brandon.jimenez@concordia.ca>
 * @copyright  Concordia University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace report_mitewiw;

//defined('MOODLE_INTERNAL') || die();
class helper {
    public static function get_nodef() : string {
        return  get_string('notyet', 'report_mitewiw');
    }

    public static function get_yesdef() : string {
        return  'ytesdes';
    }

    public static function convert_type (string $type) : string {

        if ($type == 'std') {
            return get_string('pluginorigincore', 'report_mitewiw');
        } else {

        }
        $string['pluginorigininternal'] = 'Locally developped';
        $string['pluginoriginexternal'] = 'Third party';
        return 'a';
    }
}