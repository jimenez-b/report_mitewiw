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

    private static array $admin    = ['aiplacement', 'aiprovider','antivirus', 'auth', 'booktool', 'cachelock', 'cachestore', 'calendartype', 'certificateelement', 'cleaner', 'cltr', 'communication', 'contenttype', 'customfield', 'dataformat', 'datafield', 'datapreset', 'enrol', 'factor', 'fileconverter', 'h5plib', 'logstore', 'paygw', 'profilefield', 'report', 'search', 'smsgateway', 'theme', 'tool', 'watool'];
    private static array $student  = ['atto', 'mod', 'assignsubmission', 'assignfeedback', 'block', 'editor', 'filter', 'local', 'media', 'mlbackend', 'mnetservice', 'portfolio', 'repository', 'tiny', 'webservice'];
    private static array $teacher  = ['availability', 'format', 'forumreport', 'gradeexport', 'gradeimport', 'gradereport', 'gradingform', 'ltiservice', 'message', 'qbank', 'qbehaviour', 'qformat','qtype', 'quiz', 'quizaccess', 'scormreport', 'workshopform', 'workshopallocation', 'workshopeval'];
    private static array $actively = ['mod', 'block'];
    /*
        activity plugins - students
        admin tools - admins
        antivirus - admins
        authentication - admins
        avilability restrictions - students
        blocks - students
        cahing - admins
        content bank - students
        course formats - students
        custom fields - admin
        data formats - admin
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
    
    public static function determine_main_user(string $type, string &$simple_type = '') : string {
        if (in_array($type, self::$admin) ){
            $simple_type .= 'admin';
            return get_string('pluginadmin', 'report_mitewiw');
        }
        if (in_array($type, self::$student) ){
            $simple_type .= 'student';
            return get_string('pluginstudent', 'report_mitewiw');
        }
        if (in_array($type, self::$teacher) ){
            $simple_type .= 'teacher';
            return get_string('pluginteacher', 'report_mitewiw'); 
        }
        return 'something else';
    }

    public static function determine_actively(string $type) : string {
        if (in_array($type, self::$actively) ){
            return 'actively';
        }
        return 'something else';
    }
    public static function determine_criticality(string $simple_type) : string {
        $criticality ='';
        switch ($simple_type) {
            case 'student':
                $criticality =  get_string('criticalityhigh', 'report_mitewiw');
                break;
            case 'teacher':
                $criticality = get_string('criticalitymedium', 'report_mitewiw');
                break;
            case 'admin':
                $criticality = get_string('criticalitylow', 'report_mitewiw');
                break;
        }
        return $criticality;
    }
}