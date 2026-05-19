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

use \report_mitewiw\helper;

require(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/adminlib.php');

global $PAGE, $OUTPUT;

require_login();

//use \report_mitewiw\helper;

// Print the header & check permissions.
$PAGE->set_primary_active_tab('siteadminnode');
echo $OUTPUT->header();

$view = optional_param('view', 'overview', PARAM_ALPHA);
$baseurl = new moodle_url('/report/mitewiw/index.php');
$tabs = [
    new tabobject(
        'overview',
        new moodle_url($baseurl, ['view' => 'overview']),
        get_string('tab_overview', 'report_mitewiw')
    ),
    new tabobject(
        'totals',
        new moodle_url($baseurl, ['view' => 'totals']),
        get_string('tab_totals', 'report_mitewiw')
    ),
    new tabobject(
        'usage',
        new moodle_url($baseurl, ['view' => 'usage']),
        get_string('tab_usage', 'report_mitewiw')
    ),
    new tabobject(
        'detailed',
        new moodle_url($baseurl, ['view' => 'detailed']),
        get_string('tab_detailed', 'report_mitewiw')
    ),
];
echo $OUTPUT->tabtree($tabs, $view);

switch ($view) {
    case 'overview':
        echo $OUTPUT->heading(get_string('reportname', 'report_mitewiw'));
        echo html_writer::start_div('');
        echo html_writer::empty_tag('hr');
        echo html_writer::tag('p', get_string('introreport', 'report_mitewiw'));
        echo html_writer::tag('p', get_string('componentsreport', 'report_mitewiw'));
        $items = [get_string('componentsgeneral', 'report_mitewiw'),get_string('componentsusage', 'report_mitewiw'),get_string('componentsdetailed', 'report_mitewiw')];
        $attributes = ['class' => 'list'];
        echo html_writer::alist($items, $attributes, 'ol');
        echo html_writer::tag('p', get_string('moreinfo', 'report_mitewiw'));
        echo html_writer::end_div();
        break;
    case 'totals':
        $total_plugins = 0;
        $total_HQCore_plugins = 0;
        $total_catalyst_plugins = 0;
        $total_noncatalyst_plugins = 0;
        $total_internal_plugins = 0;
        $total_actively_used = 0;
        $total_critical = 0;

        echo $OUTPUT->heading(get_string('generaloverview', 'report_mitewiw'));
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
            }
        }
        $table = new html_table();
        $table->attributes['class'] = 'generaltable';
        $table->head = [get_string('indicator', 'report_mitewiw'),
                        get_string('value', 'report_mitewiw')];

        $table->data = [
                        [get_string('totalplugins', 'report_mitewiw'),$total_plugins],
                        [get_string('totalcore', 'report_mitewiw'),$total_HQCore_plugins],
                        [get_string('totalcatalyst', 'report_mitewiw'),$total_catalyst_plugins],
                        [get_string('totalnoncatalyst', 'report_mitewiw'),$total_noncatalyst_plugins],
                        [get_string('totalinternal', 'report_mitewiw'),$total_internal_plugins]
                        ];
        
        echo html_writer::start_div('container-fluid');
        echo html_writer::start_div('row');
        echo html_writer::start_div('col-6');
        echo html_writer::table($table);
        echo html_writer::end_div();
        echo html_writer::start_div('col-6');
        $CFG->chart_colorset = ['#F98012', '#880000', '#028609', '#0072a8'];
        $chart = new \core\chart_pie();
        $serie = new core\chart_series('Plugins installed', [$total_HQCore_plugins, $total_catalyst_plugins, $total_noncatalyst_plugins, $total_internal_plugins]);
        $chart->set_doughnut(true);
        $chart->add_series($serie);
        $chart->set_title(get_string('totalplugins', 'report_mitewiw'));
        $chart->set_labels([get_string('totalchartcore', 'report_mitewiw'),get_string('totalchartcatalyst', 'report_mitewiw'),get_string('totalchartnoncatalyst', 'report_mitewiw'),get_string('totalchartinternal', 'report_mitewiw')]);
        echo $OUTPUT->render($chart);
        echo html_writer::end_div();
        echo html_writer::end_div();
        echo html_writer::end_div();
        /*
        Indicateur / Valeur
        Nombre de plugins activement utilisés (visibles)
        Nombre de plugins critiques (impact direct étudiants)
        */
        break;
    case 'usage':
        echo $OUTPUT->heading(get_string('usageoverview', 'report_mitewiw'));

        
        $lalo = helper::get_nodef();
        echo "<p>Plugins used by student $lalo</p>";
        echo "<p>Plugins used by only the teachers $lalo</p>";
        echo "<p>Plugins only for the admins $lalo</p>";
        echo "<p>Plugins that create content (pages, activities, documents) $lalo</p>";
        echo "<p>Plugins that help evaluate (quiz, assignment, proctoring, etc.) $lalo</p>";
        break;
    case 'detailed':
        echo $OUTPUT->heading(get_string('detailedbreakdown', 'report_mitewiw'));

        $pm = \core_plugin_manager::instance();
        $types = $pm->get_plugin_types();

        echo "<hr>";

        foreach ($types as $t => $path) {
            $plugins = $pm->get_installed_plugins($t);
            if (count($plugins)===0) {
                continue;
            }
            else {
                $parent = $pm->get_parent_of_subplugin ($t);
                $type_displayname = helper::get_type_string($t, $parent);
                echo html_writer::tag('h3', $type_displayname." ($t)");
                //echo "<h2>$t</h2>";
                $table = new html_table();
                $table->attributes['class'] = 'generaltable';
                $table->head = ['Plugin name',
                                'Component',
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
                    $main_user = helper::determine_main_user($t, $parent);
                    /*if (str_contains($t, "tool")) {
                        $main_user = get_string('pluginadmin', 'report_mitewiw');
                    }*/

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
        break;
    default:
        echo $OUTPUT->heading(get_string('notyet', 'report_mitewiw'));
        break;
}


echo $OUTPUT->footer();