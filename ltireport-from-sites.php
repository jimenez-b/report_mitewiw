<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <title>LTI report</title>
</head>
<body>
<?php
    $term = 'all';
    $filter = true;

    //if get nor argv are set then we do the whole query
    if (isset($_GET['term'])){
        $term   =  $_GET['term'];
    } else {
        if (isset($argv[1])) {
            $term   =  $argv[1];
        }
    }

    if (isset($_GET['filter'])){
        $filter   =  $_GET['filter'];
    } else {
        if (isset($argv[2])) {
            $filter   =  $argv[2];
        }
    }

    $message = '';
    $sqlterms = '';
    if ($term == 'all'){
        $message = 'all terms';
        $sqlterms = "(shortname LIKE '%2241%' OR
                    shortname LIKE '%2242%' OR
                    shortname LIKE '%2243%' OR
                    shortname LIKE '%2244%' OR
                    shortname LIKE '%2251%')";
    } else {
        $message = "term $term";
        $sqlterms = "shortname LIKE '%$term%'";
    }
    echo "<h1>LTI report for $message</h1>\r\n";
     /**
    * Function to connect to a Postgresql database
    * @return      object $pgdb connection on success
    */
    function postgres_connect() {
        $port = 5432;
        $host = 'mdl41-prod-db1';
        $dbname = 'concordia-prod-moodle';
        $dbuser = 'bjimenez';
        $dbpass = 'k87yH89iG95';
        $connstring = "host={$host} port={$port} dbname={$dbname} user={$dbuser} password={$dbpass}";
        //echo $connstring;
        //die;
        $pgdb = pg_connect($connstring);
        if (empty($pgdb)) {
            exit(1);
        }
        return $pgdb;
    }

    $pgdb = postgres_connect();

    $sql = '';
    $sql = "SELECT id, shortname, idnumber
            FROM mdl_course
            WHERE
            shortname NOT LIKE '%ERIC%' AND
            shortname NOT LIKE '%Template%' AND
            $sqlterms
            ORDER BY id ASC";

    $coursesquery = pg_query($pgdb, $sql);
    if(!$coursesquery) {
        die("Error executing courses query");
    };
    // we have a list of courses, excluding templates and courses created by Eric Katchan
    while ($course = pg_fetch_row($coursesquery)) {

        $sql = "SELECT id, instanceid FROM mdl_context WHERE instanceid = $course[0] AND contextlevel = 50";
        $contextquery = pg_query($pgdb, $sql);
        if(!$contextquery) {
            die("Error executing context query");
        };
        //we get the context for the course
        $context = pg_fetch_row($contextquery); //as we only should get one result

        $sql = "SELECT ra.id, ra.roleid,ra.contextid,ra.userid, u.lastname, u.firstname, u.email
                FROM mdl_role_assignments ra
                INNER JOIN mdl_user u ON u.id = ra.userid
                WHERE ra.contextid = $context[0] AND ra.roleid = 3
                ORDER BY ra.userid ASC";
        $teachersquery = pg_query($pgdb, $sql);
        if(!$teachersquery) {
            die("Error executing teacher query");
        };
        //we get the teachers for the course
        $additional_filter = '';
        if ($filter == 'true') {
            $additional_filter = "AND lt.tooldomain NOT LIKE '%yuja%'
                                  AND lt.tooldomain NOT LIKE '%zoom%'
                                  AND lt.tooldomain NOT LIKE '%betterknow%'";
        }
        $sql = "SELECT lti.id, lti.course, lti.name, lti.typeid,  lt.tooldomain, lt.name, lt.baseurl
                FROM mdl_lti lti
                INNER JOIN mdl_lti_types lt ON lti.typeid = lt.id
                WHERE lti.course = $course[0]
                AND lt.tooldomain NOT LIKE '%reserves%'
                $additional_filter";
        $ltisquery = pg_query($pgdb, $sql);
        if(!$ltisquery) {
            die("Error executing LTIs query");
        };
        //we get the LTIs for said course
        $rows = pg_num_rows($ltisquery);
        if ($rows > 0) {
            //we do have LTIs in this course, so we start dumping the data
            echo "<h2>COURSE: <a href='https://moodle.concordia.ca/moodle/course/view.php?id=$course[0]'  target='_blank'>$course[1]</a> </h2>". PHP_EOL;
            echo "<h3>Teacher:</h3>". PHP_EOL;
            echo "<ul style='list-style-type:none;'>". PHP_EOL;
            while ($teacher = pg_fetch_row($teachersquery)) {
                echo "<li> $teacher[4], $teacher[5], email: <a href='mailto:$teacher[6]'>$teacher[6]</a> </li>". PHP_EOL;
            }
            echo "</ul>";
            echo "<h3>LTIs ($rows):</h3>". PHP_EOL;
            echo "<ul style='list-style-type:none;'>". PHP_EOL;
            while ($lti = pg_fetch_row($ltisquery)) {
                echo "<li> $lti[2], $lti[5] - <a href='$lti[6]' target='_blank'>$lti[6]</a> </li>". PHP_EOL;
            }
            echo "</ul>". PHP_EOL;
            echo "<hr>". PHP_EOL;
        }
    }
?>
</body>
</html>