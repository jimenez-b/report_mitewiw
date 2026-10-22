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
// report_mitewiw;
namespace report_mitewiw\local;


//defined('MOODLE_INTERNAL') || die();
class helper {

    private int $total_plugins = 0;
    private int $total_HQCore_plugins = 0;
    private int $total_catalyst_plugins = 0;
    private int $total_noncatalyst_plugins = 0;
    private int $total_internal_plugins = 0;
    private int $total_actively_used = 0;
    private int $total_critical = 0;

    private int $total_students = 0;
    private int $total_teachers = 0;
    private int $total_admins = 0;
    private int $total_content = 0;
    private int $total_evaluate = 0;
    
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

    public function create_report_plugins() {
        $pm = \core_plugin_manager::instance();
        $types = $pm->get_plugin_types();

        foreach ($types as $t => $path) {
            $plugins = $pm->get_installed_plugins($t);
            foreach ($plugins as $p => $version) {
                $this->total_plugins++;
                $frankenstein = (string) $t."_".$p;
                $plug_info = $pm->get_plugin_info($frankenstein);
                $actively = helper::determine_actively($t);
                if ($actively == 'actively'){
                    $this->total_actively_used++; 
                }
                $simple = '';
                $main_user = helper::determine_main_user($t, $simple);
                switch ($simple) {
                    case 'student':
                        $this->total_students++;
                        $this->total_critical++;
                        break;
                    case 'teacher':
                        $this->total_teachers++;
                        break;
                    case 'admin':
                        $this->total_admins++;
                        break;
                }
                if ($plug_info->source == 'std') {
                    $this->total_HQCore_plugins ++;
                } else {
                    $external_source2 = $pm->get_remote_plugin_info($frankenstein, $plug_info->versiondisk, false);
                    if (str_contains($external_source2->source, "catalyst")) {
                        $this->total_catalyst_plugins ++;
                    } else {
                        if (str_contains($external_source2->source, "Concordia") || str_contains($external_source2->source, "jimenez-b") ) {
                            $this->total_internal_plugins ++;
                        } else {
                            $this->total_noncatalyst_plugins ++;
                        } 
                    }
                }
            }
        }
    }
    /*
    $total_plugins = 0;
    $total_HQCore_plugins = 0;
    $total_catalyst_plugins = 0;
    $total_noncatalyst_plugins = 0;
    $total_internal_plugins = 0;
    $total_actively_used = 0;
    $total_critical = 0;

    $pma = \core_plugin_manager::instance();
    $types = $pma->get_plugin_types();

    foreach ($types as $t => $path) {
        $plugins = $pma->get_installed_plugins($t);
        foreach ($plugins as $p => $version) {
            $total_plugins ++;
            $frankenstein = (string) $t."_".$p;
            $plug_info = $pma->get_plugin_info($frankenstein);
            //string for the type of plugin
            //moodle standard plugin
            if ($plug_info->source == 'std') {
                $total_HQCore_plugins ++;
            } else {
                $external_source2 = $pma->get_remote_plugin_info($frankenstein, $plug_info->versiondisk, false);
                if (str_contains($external_source2->source, "catalyst")) {
                    $total_catalyst_plugins ++;
                } else {
                    if (str_contains($external_source2->source, "Concordia") || str_contains($external_source2->source, "jimenez-b") ) {
                        $total_internal_plugins ++;
                    } else {
                        $total_noncatalyst_plugins ++;
                    } 
                }
            }
            $simple = '';
            $main_user = helper::determine_main_user($t, $simple);
            if ($simple == 'student'){
                $total_critical++; 
            }
            $actively = helper::determine_actively($t);
            if ($actively == 'actively'){
                $total_actively_used++; 
            }
        }
    }

    foreach ($types as $t => $path) {
            $plugins = $pmb->get_installed_plugins($t);
            foreach ($plugins as $p => $version) {
                $total_plugins ++;
                $simple = '';
                $main_user = helper::determine_main_user($t, $simple);
                switch ($simple) {
                    case 'student':
                        $total_students++;
                        break;
                    case 'teacher':
                        $total_teachers++;
                        break;
                    case 'admin':
                        $total_admins++;
                        break;
                }
            }
        }
    */
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