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

    private static $admin   = ['antivirus', 'auth', 'booktool', 'cleaner', 'datafield', 'datapreset', 'paygw', 'report', 'smsgateway', 'theme', 'tool', 'watool'];
    private static $student = ['mod', 'assignsubmission', 'assignfeedback', 'block', 'ltiservice'];

    /*
        activity plugins - students
        

        authentication - admins
        avilability restrictions - students
        
        cahing - admins
        content bank - students
        course formats - students
        
        document converters - admins
        enrolments - students
        filters  - students
        local - admin
        logging - admins
        machine - admins
        media player - students
        payments - admin
        plagiarism - students
        portfolios - students
        question bank - admins teachers
        q behav - admins teachers
        question types - admins teachers
        reports- admins
        repositories - students
        search - students
        sms - admins
        text - students
    */

    public static function get_nodef() : string {
        return  get_string('notyet', 'report_mitewiw');
    }

    public static function get_yesdef() : string {
        return  'yesdes';
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

    public static function get_type_string(string $type, string $parent) : string {
        if (empty($parent)) {
            $type_to_get = (get_string_manager()->string_exists( 'type_'.$type.'_plural', 'core_plugin')) ? get_string('type_'.$type.'_plural', 'core_plugin') : 'error';
        } else {
            $type_to_get = get_string('pluginname', $parent) .' / '.get_string("subplugintype_".$type."_plural", $parent);
        }
        return  $type_to_get;
    }
    
    public static function determine_main_user(string $type, string $parent) : string {
        $principal_user = 'something else';
        if (in_array($type, self::$admin) ){
            return $principal_user = get_string('pluginadmin', 'report_mitewiw');
        }
        if (in_array($type, self::$student) ){
            return $principal_user = get_string('pluginstudent', 'report_mitewiw');
        }
        return $principal_user;
    }
}