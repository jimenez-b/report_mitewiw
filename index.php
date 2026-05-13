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
 * Config changes report
 *
 * @package    report
 * @subpackage mitewiw
 * @author     Brandon Jimenez <brandon.jimenez@concordia.ca>
 * @copyright  Concordia University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/adminlib.php');

//use \report_mitewiw\helper;

// Print the header & check permissions.
$PAGE->set_primary_active_tab('siteadminnode');
echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('reportname', 'report_mitewiw'));

$pm = \core_plugin_manager::instance();
$types = $pm->get_plugin_types();

echo "<hr>";

foreach ($types as $t => $path) {
    $plugins = $pm->get_installed_plugins($t);
    if (count($plugins)===0) {
        continue;
    }
    else {
        echo "<h2>$t</h2>";
        $table = new html_table();
        $table->attributes['class'] = 'generaltable';
        $table->head = ['Plugin name',
                        'Frankenstein',
                        'Type',
                        'Principal user',
                        'Criticality',
                        'Number of user',
                        'Installed version',
                        'Source/URL',
                        'Installation date',
                        'Last update'];
        //$lolo3 = new helper;
        //$testclass = report_mitewiw\helper::get_yesdef();
        foreach ($plugins as $p => $version) {
            $frankenstein = (string) $t."_".$p;
            $external = $pm->plugin_external_source($frankenstein);
            $external_source = '';
            $type = '';
            $main_user = 'Not yet determined';
            /*echo "<p>$p ($version)</p><br>";
            echo "<p>$frankenstein</p><br>";*/
            $plug_info = $pm->get_plugin_info($frankenstein);

            /*if ($plug_info->source != 'std' && $external == '') {
                $external_source = $pm->get_remote_plugin_info($frankenstein, $plug_info->versiondisk, false);
            }*/

            if ($frankenstein == 'report_mitewiw' ) {
                $external_source = $pm->get_remote_plugin_info($frankenstein, $plug_info->versiondisk, false);
                echo var_dump($external_source);
            }
            //string for the type of plugin
            //moodle standard plugin
            if ($plug_info->source == 'std') {
                $type = get_string('pluginorigincore', 'report_mitewiw');
                $external_source = get_string('noexternalsource', 'report_mitewiw');
            } else {
                //non-standard
                if ($external != '') {
                    $source = $pm->get_remote_plugin_info($frankenstein, $plug_info->versiondisk, false);
                    $external_source = $source->source;
                    if (str_contains($external_source, "Concordia") || str_contains($external_source, "jimenez-b") ) {
                        //not fetching the URL right now, to be checked
                        $type = get_string('pluginorigininternal', 'report_mitewiw');
                    } else {
                        $type = get_string('pluginoriginexternal', 'report_mitewiw');
                    } 
                }
            }
            if (str_contains($t, "tool")) {
                $main_user = get_string('pluginadmin', 'report_mitewiw');
            }

            $table->data[] = [
                $plug_info->displayname, 
                $frankenstein, 
                $type, 
                $main_user, 
                'Not yet', 
                'Not yet', 
                $plug_info->versiondisk,
                $external_source,
                'Not yet',
                'Not yet'];
            
        }
        echo html_writer::table($table);
    }
    echo "<hr>";
}


echo $OUTPUT->footer();