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

use \report_mitewiw\local\helper;

require(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/adminlib.php');

global $PAGE, $OUTPUT, $DB;

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
    new tabobject(
        'ltis',
        new moodle_url($baseurl, ['view' => 'ltis']),
        get_string('tab_ltis', 'report_mitewiw')
    ),
];
echo $OUTPUT->tabtree($tabs, $view);
$output = $PAGE->get_renderer('report_mitewiw');

switch ($view) {
    case 'overview':
        echo $OUTPUT->heading(get_string('reportname', 'report_mitewiw'));
        $items   = [get_string('componentlistgeneral', 'report_mitewiw'),
                    get_string('componentlistusage', 'report_mitewiw'),
                    get_string('componentlistdetailed', 'report_mitewiw'),
                    get_string('componentlistltis', 'report_mitewiw')];
        $attributes = ['class' => 'list'];
        echo $output->render_overview($items,$attributes);
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
        $table_totals = new html_table();
        $table_totals->attributes['class'] = 'generaltable';
        $table_totals->head = [get_string('indicator', 'report_mitewiw'),
                        get_string('value', 'report_mitewiw')];

        $table_totals->data = [
                        [get_string('totalplugins', 'report_mitewiw'),$total_plugins],
                        [get_string('totalcore', 'report_mitewiw'),$total_HQCore_plugins],
                        [get_string('totalcatalyst', 'report_mitewiw'),$total_catalyst_plugins],
                        [get_string('totalnoncatalyst', 'report_mitewiw'),$total_noncatalyst_plugins],
                        [get_string('totalinternal', 'report_mitewiw'),$total_internal_plugins]
                        ];

        //$total_actively_used = rand(1, 100);
        $table_active = new html_table();
        $table_active->attributes['class'] = 'generaltable';
        $table_active->head = [get_string('indicator', 'report_mitewiw'),
                        get_string('value', 'report_mitewiw')];
        
        $table_active->data = [
                        [get_string('totalcritical', 'report_mitewiw'),$total_critical],
                        [get_string('totalactive', 'report_mitewiw'),$total_actively_used]
                        ];
        echo html_writer::start_div('container-fluid');
        echo html_writer::start_div('row');
        echo html_writer::start_div('col-6');
        echo html_writer::table($table_totals);
        echo html_writer::end_div();
        echo html_writer::start_div('col-6');
        $CFG->chart_colorset = ['#F98012', '#880000', '#028609', '#0072a8'];
        $chart = new \core\chart_pie();
        $serie = new core\chart_series('Plugins installed', [$total_HQCore_plugins, $total_catalyst_plugins, $total_noncatalyst_plugins, $total_internal_plugins]);
        $chart->set_doughnut(true);
        $chart->add_series($serie);
        $chart->set_title(get_string('totalplugins', 'report_mitewiw').": $total_plugins");
        $chart->set_labels([get_string('totalchartcore', 'report_mitewiw'),get_string('totalchartcatalyst', 'report_mitewiw'),get_string('totalchartnoncatalyst', 'report_mitewiw'),get_string('totalchartinternal', 'report_mitewiw')]);
        echo $OUTPUT->render($chart);
        echo html_writer::end_div();
        echo html_writer::end_div();
        echo html_writer::empty_tag('hr');
        echo html_writer::start_div('row');
        echo html_writer::start_div('col-6');
        echo html_writer::table($table_active);
        echo html_writer::end_div();
        echo html_writer::start_div('col-6');
        $chart = new core\chart_bar();
        $chart->set_horizontal(true);
        //$chart->set_stacked(true);
        $serie1 = new core\chart_series(get_string('totalplugins', 'report_mitewiw'), [$total_plugins, $total_plugins]);
        $serie2 = new core\chart_series(get_string('active/critical', 'report_mitewiw'), [$total_critical, $total_actively_used]);
        $chart->add_series($serie1);
        $chart->add_series($serie2);
        $chart->set_labels([get_string('totalcriticalshort', 'report_mitewiw'),get_string('totalactiveshort', 'report_mitewiw')]);
        echo $OUTPUT->render($chart, false);
        echo html_writer::end_div();
        echo html_writer::end_div();
        echo html_writer::end_div();
        break;
    case 'usage':
        echo $OUTPUT->heading(get_string('usageoverview', 'report_mitewiw'));

        $total_plugins = 0;
        $total_students = 0;
        $total_teachers = 0;
        $total_admins = 0;
        $total_content = 0;
        $total_evaluate = 0;
        
        $pmb = \core_plugin_manager::instance();
        $types = $pmb->get_plugin_types();

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

        $table_totals = new html_table();
        $table_totals->attributes['class'] = 'generaltable';
        $table_totals->head = [get_string('indicator', 'report_mitewiw'),
                        get_string('value', 'report_mitewiw')];

        $table_totals->data = [
                        [get_string('pluginstudent', 'report_mitewiw'),$total_students],
                        [get_string('pluginteacher', 'report_mitewiw'),$total_teachers],
                        [get_string('pluginadmin', 'report_mitewiw'),$total_admins],
                        [get_string('totalplugins', 'report_mitewiw'),$total_plugins]
                        ];
        
        echo html_writer::start_div('container-fluid');
        echo html_writer::start_div('row');
        echo html_writer::start_div('col-6');
        echo html_writer::table($table_totals);
        echo html_writer::end_div();
        echo html_writer::start_div('col-6');
        $CFG->chart_colorset = ['#508212', '#004085', '#c9a859'];
        $chart = new \core\chart_pie();
        $serie = new core\chart_series('Plugins installed', [$total_students, $total_teachers, $total_admins]);
        $chart->set_doughnut(true);
        $chart->add_series($serie);
        $chart->set_title(get_string('totalplugins', 'report_mitewiw').": $total_plugins");
        $chart->set_labels([get_string('pluginstudent', 'report_mitewiw'),get_string('pluginteacher', 'report_mitewiw'),get_string('pluginadmin', 'report_mitewiw')]);
        echo $OUTPUT->render($chart);
        echo html_writer::end_div();
        echo html_writer::end_div();
        /*
        echo html_writer::empty_tag('hr');
        echo html_writer::start_div('row');
        echo html_writer::start_div('col-6');
        $lalo = helper::get_nodef();
        echo "<p>total plugins $total_plugins</p>";
        echo "<p>Plugins used by student $total_students</p>";
        echo "<p>Plugins used by only the teachers $total_teachers</p>";
        echo "<p>Plugins only for the admins $total_admins</p>";
        echo html_writer::end_div();
        echo html_writer::start_div('col-6');
        echo "<p>Plugins that create content (pages, activities, documents) $lalo</p>";
        echo "<p>Plugins that help evaluate (quiz, assignment, proctoring, etc.) $lalo</p>";
        echo html_writer::end_div();
        echo html_writer::end_div();
        */
        echo html_writer::end_div();
        
        break;
    case 'detailed':
        echo $OUTPUT->heading(get_string('detailedbreakdown', 'report_mitewiw'));
        echo html_writer::empty_tag('hr');
        $pm = \core_plugin_manager::instance();
        $types = $pm->get_plugin_types();
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
                    $simple = '';
                    $main_user   = helper::determine_main_user($t, $simple);
                    $criticality = helper::determine_criticality($simple);

                    $version = isset($plug_info->release)? "($plug_info->release) $plug_info->versiondisk" : $plug_info->versiondisk;
                    $table->data[] = [
                        $plug_info->displayname, 
                        $frankenstein, 
                        $type, 
                        $main_user, 
                        $criticality, 
                        'Not yet', 
                        $version,
                        $external_source,
                        'Not yet',
                        'Not yet'];
                    
                }
                echo html_writer::table($table);
            }
            echo "<hr>";
        }
        break;
    case 'ltis':
        echo $OUTPUT->heading(get_string('ltibreakdown', 'report_mitewiw'));
        $lalo = helper::get_nodef();
        echo "<p>ltis not yet computed $lalo</p>";
        $tableDB = 'course';
        $select = "shortname NOT LIKE '%ERIC%' AND shortname NOT LIKE '%Template%' and id <> 1";
        $conditions = null;
        $sort = 'id';
        $fields = 'id, shortname, fullname, idnumber, category, startdate, enddate';
        //get courses
        $rs = $DB->get_recordset_select($tableDB, $select, $conditions, $sort, $fields);
        if ($rs->valid()) {
            // The recordset contains some records.
            $table = new html_table();
            $table->attributes['class'] = 'generaltable';
            $table->head = ['Course Shortname',
                            'Course category',
                            'Teacher name',
                            'Teacher email',
                            'Activity name',
                            'LTI name',
                            'LTI URL',
                            'Preconfigured'];
            foreach ($rs as $course) {
                //get the course category
                $course_cat = $DB->get_field('course_categories', 'name', ['id' => $course->category]);

                //echo "<p>Record ID: $course->id</p>";
                //echo "<p>Shortname: $course->shortname</p>";
                //echo "<p>idnumber: $course->idnumber</p>";
                //echo "<p>categoryid: $course->idnumber and name $course_cat</p>";
                //echo "<p>startdate: $course->startdate</p>";
                //echo "<p>enddate: $course->enddate</p>";
                //echo "<p>----</p>";
                $contextquery = $DB->get_record('context', ['instanceid' => $course->id, 'contextlevel' => 50],  'id,instanceid');
                //echo "<p>contextquery id: $contextquery->id</p>";
                //echo "<p>contextquery instanceid: $contextquery->instanceid</p>";
                

                
                echo "<p>----</p>";
                $sql =  "SELECT ra.id, ra.roleid,ra.contextid,ra.userid, u.lastname, u.firstname, u.email
                           FROM mdl_role_assignments ra
                     INNER JOIN mdl_user u ON u.id = ra.userid
                          WHERE ra.contextid = :contextid
                            AND ra.roleid = :roleid
                       ORDER BY ra.userid ASC";
                $params = array('contextid' => $contextquery->id, 'roleid' => 3);
                $teachersquery = $DB->get_records_sql($sql, $params);
                $teachers = $t_emails = '';
                foreach ($teachersquery as $teacher) {
                    //echo "<p>ra id: $teacher->id</p>";
                    //echo "<p>ra roleid: $teacher->roleid</p>";
                    //echo "<p>ra contextid: $teacher->contextid</p>";
                    //echo "<p>ra userid: $teacher->userid</p>";
                    //echo "<p>ra lastname: $teacher->lastname</p>";
                    //echo "<p>ra firstname: $teacher->firstname</p>";
                    //echo "<p>ra email: $teacher->email</p>";
                    $teachers .= "<span id='$teacher->userid'>$teacher->firstname, $teacher->lastname</span>";
                    $t_emails .= "<span id='email_$teacher->userid'>$teacher->email</span>";
                }

                $ltiquery = $DB->get_records('lti', array("course"=>$course->id),'','id,course,name,typeid');

                foreach ($ltiquery as $lti) {
                    $ltitypes = $DB->get_record('lti_types', array("id"=>$lti->typeid),'id,tooldomain,name,baseurl,state');
                    $state = '';
                    if ($ltitypes->state == 1) {
                        $state = 'Active';
                    } elseif ($ltitypes->state == 2) {
                        $state = 'Pending';
                    } else {
                        $state = 'Rejected';
                    }
                    $table->data[] = [
                        "<h2>COURSE: <a href='https://moodle.concordia.ca/moodle/course/view.php?id=$course->id'  target='_blank'>$course->shortname</a> </h2>", 
                        $course_cat, 
                        $teachers,
                        $t_emails,
                        $lti->name, 
                        $ltitypes->name,
                        "<a href='$ltitypes->baseurl' target='_blank'>$ltitypes->baseurl</a> </li>", 
                        $state];
                    $table->rowclasses[] = "$ltitypes->tooldomain";
                        /*
                         $additional_filter = "AND lt.tooldomain NOT LIKE '%yuja%'
                                  AND lt.tooldomain NOT LIKE '%zoom%'
                                  AND lt.tooldomain NOT LIKE '%betterknow%'";
                                  */
                }
                echo html_writer::table($table);
                echo "<hr>";
            }
        }
        $rs->close(); 
        break;
    default:
        echo $OUTPUT->heading(get_string('notyet', 'report_mitewiw'));
        break;
}


echo $OUTPUT->footer();