external source json

object(core\update\remote_info)#2259 (8) {
  ["id"]=>
  int(2248)
  ["name"]=>
  string(5) "Trema"
  ["component"]=>
  string(11) "theme_trema"
  ["source"]=>
  string(48) "https://github.com/trema-tech/moodle-theme_trema"
  ["doc"]=>
  string(68) "https://github.com/trema-tech/moodle-theme_trema/blob/main/README.md"
  ["bugs"]=>
  string(55) "https://github.com/trema-tech/moodle-theme_trema/issues"
  ["discussion"]=>
  NULL
  ["version"]=>
  object(stdClass)#2267 (13) {
    ["id"]=>
    int(41769)
    ["version"]=>
    string(10) "2026051100"
    ["release"]=>
    string(32) "Moodle LMS Theme - Trema 5.2.0.0"
    ["maturity"]=>
    int(200)
    ["downloadurl"]=>
    string(81) "https://moodle.org/plugins/download.php/41769/theme_trema_moodle52_2026051100.zip"
    ["downloadmd5"]=>
    string(32) "5348752a4c4d69810c0b4e9238b072a5"
    ["vcssystem"]=>
    string(3) "git"
    ["vcssystemother"]=>
    NULL
    ["vcsrepositoryurl"]=>
    string(48) "https://github.com/trema-tech/moodle-theme_trema"
    ["vcsbranch"]=>
    NULL
    ["vcstag"]=>
    string(7) "5.2.0.0"
    ["timecreated"]=>
    int(1778537621)
    ["supportedmoodles"]=>
    array(8) {
      [0]=>
      object(stdClass)#2266 (2) {
        ["version"]=>
        int(2022111500)
        ["release"]=>
        string(3) "4.1"
      }
      [1]=>
      object(stdClass)#2253 (2) {
        ["version"]=>
        int(2023041400)
        ["release"]=>
        string(3) "4.2"
      }
      [2]=>
      object(stdClass)#2271 (2) {
        ["version"]=>
        int(2023092300)
        ["release"]=>
        string(3) "4.3"
      }
      [3]=>
      object(stdClass)#2272 (2) {
        ["version"]=>
        int(2024041200)
        ["release"]=>
        string(3) "4.4"
      }
      [4]=>
      object(stdClass)#2273 (2) {
        ["version"]=>
        int(2024100700)
        ["release"]=>
        string(3) "4.5"
      }
      [5]=>
      object(stdClass)#2274 (2) {
        ["version"]=>
        int(2025041400)
        ["release"]=>
        string(3) "5.0"
      }
      [6]=>
      object(stdClass)#2275 (2) {
        ["version"]=>
        int(2025100600)
        ["release"]=>
        string(3) "5.1"
      }
      [7]=>
      object(stdClass)#2276 (2) {
        ["version"]=>
        int(2026032700)
        ["release"]=>
        string(3) "5.2"
      }
    }
  }
}

-------------------------------------


object(core\plugininfo\theme)#2268 (20) {
  ["type"]=>
  string(5) "theme"
  ["typerootdir"]=>
  string(19) "/var/www/html/theme"
  ["name"]=>
  string(5) "trema"
  ["displayname"]=>
  string(5) "Trema"
  ["source"]=>
  string(3) "ext"
  ["rootdir"]=>
  string(25) "/var/www/html/theme/trema"
  ["versiondisk"]=>
  int(2025100900)
  ["versiondb"]=>
  string(10) "2025100900"
  ["versionrequires"]=>
  int(2022021800)
  ["pluginsupported"]=>
  NULL
  ["pluginincompatible"]=>
  NULL
  ["release"]=>
  string(7) "5.1.0.0"
  ["dependencies"]=>
  array(1) {
    ["theme_boost"]=>
    int(2018051400)
  }
  ["instances"]=>
  NULL
  ["sortorder"]=>
  NULL
  ["pluginman"]=>
  object(core\plugin_manager)#132 (10) {
    ["pluginsinfo":protected]=>
    array(68) {
      ["mod"]=>
      array(25) {
        ["assign"]=>
        object(core\plugininfo\mod)#362 (20) {
          ["type"]=>
          string(3) "mod"
          ["typerootdir"]=>
          string(17) "/var/www/html/mod"
          ["name"]=>
          string(6) "assign"
          ["displayname"]=>
          string(10) "Assignment"
          ["source"]=>
          string(3) "std"
          ["rootdir"]=>
          string(24) "/var/www/html/mod/assign"
          ["versiondisk"]=>
          int(2024100701)
          ["versiondb"]=>
          string(10) "2024100701"
          ["versionrequires"]=>
          int(2024100100)
          ["pluginsupported"]=>
          NULL
          ["pluginincompatible"]=>
          NULL
          ["release"]=>
          NULL
          ["dependencies"]=>
          array(0) {
          }
          ["instances"]=>
          NULL
          ["sortorder"]=>
          NULL
          ["pluginman"]=>
          *RECURSION*
          ["availableupdates":protected]=>
          NULL
          ["supported"]=>
          NULL
          ["incompatible"]=>
          NULL
          ["component"]=>
          string(10) "mod_assign"
        }
        ["bigbluebuttonbn"]=>
        object(core\plugininfo\mod)#370 (20) {
          ["type"]=>
          string(3) "mod"
          ["typerootdir"]=>
          string(17) "/var/www/html/mod"
          ["name"]=>
          string(15) "bigbluebuttonbn"
          ["displayname"]=>
          string(13) "BigBlueButton"
          ["source"]=>
          string(3) "std"
          ["rootdir"]=>
          string(33) "/var/www/html/mod/bigbluebuttonbn"
          ["versiondisk"]=>
          int(2024100700)
          ["versiondb"]=>
          string(10) "2024100700"
          ["versionrequires"]=>
          int(2024100100)
          ["pluginsupported"]=>
          NULL
          ["pluginincompatible"]=>
          NULL
          ["release"]=>
          NULL
          ["dependencies"]=>
          array(0) {
          }
          ["instances"]=>
          NULL
          ["sortorder"]=>
          NULL
          ["pluginman"]=>
          *RECURSION*
          ["availableupdates":protected]=>
          NULL
          ["supported"]=>
          NULL
          ["incompatible"]=>
          NULL
          ["component"]=>
          string(19) "mod_bigbluebuttonbn"
        }
        ["book"]=>
        object(core\plugininfo\mod)#1504 (20) {
          ["type"]=>
          string(3) "mod"
          ["typerootdir"]=>
          string(17) "/var/www/html/mod"
          ["name"]=>
          string(4) "book"
          ["displayname"]=>
          string(4) "Book"
          ["source"]=>
          string(3) "std"
          ["rootdir"]=>
          string(22) "/var/www/html/mod/book"
          ["versiondisk"]=>
          int(2024100700)
          ["versiondb"]=>
          string(10) "2024100700"
          ["versionrequires"]=>
          int(2024100100)
          ["pluginsupported"]=>
          NULL
          ["pluginincompatible"]=>
          NULL
          ["release"]=>
          NULL
          ["dependencies"]=>
          array(0) {
          }
          ["instances"]=>
          NULL
          ["sortorder"]=>
          NULL
          ["pluginman"]=>
          *RECURSION*
          ["availableupdates":protected]=>
          NULL
          ["supported"]=>
          NULL
          ["incompatible"]=>
          NULL
          ["component"]=>
          string(8) "mod_book"
        }
        ["chat"]=>
        object(core\plugininfo\mod)#1498 (20) {
          ["type"]=>
          string(3) "mod"
          ["typerootdir"]=>
          string(17) "/var/www/html/mod"
          ["name"]=>
          string(4) "chat"
          ["displayname"]=>
          string(4) "Chat"
          ["source"]=>
          string(3) "std"
          ["rootdir"]=>
          string(22) "/var/www/html/mod/chat"
          ["versiondisk"]=>
          int(2024100700)
          ["versiondb"]=>
          string(10) "2024100700"
          ["versionrequires"]=>
          int(2024100100)
          ["pluginsupported"]=>
          NULL
          ["pluginincompatible"]=>
          NULL
          ["release"]=>
          NULL
          ["dependencies"]=>
          array(0) {
          }
          ["instances"]=>
          NULL
          ["sortorder"]=>
          NULL
          ["pluginman"]=>
          *RECURSION*
          ["availableupdates":protected]=>
          NULL
          ["supported"]=>
          NULL
          ["incompatible"]=>
          NULL
          ["component"]=>
          string(8) "mod_chat"
        }
        ["choice"]=>
        object(core\plugininfo\mod)#1771 (20) {
          ["type"]=>
          string(3) "mod"
          ["typerootdir"]=>
          string(17) "/var/www/html/mod"
          ["name"]=>
          string(6) "choice"
          ["displayname"]=>
          string(6) "Choice"
          ["source"]=>
          string(3) "std"
          ["rootdir"]=>
          string(24) "/var/www/html/mod/choice"
          ["versiondisk"]=>
          int(2024100700)
          ["versiondb"]=>
          string(10) "2024100700"
          ["versionrequires"]=>
          int(2024100100)
          ["pluginsupported"]=>
          NULL
          ["pluginincompatible"]=>
          NULL
          ["release"]=>
          NULL
          ["dependencies"]=>
          array(0) {
          }
          ["instances"]=>
          NULL
          ["sortorder"]=>
          NULL
          ["pluginman"]=>
          *RECURSION*
          ["availableupdates":protected]=>
          NULL
          ["supported"]=>
          NULL
          ["incompatible"]=>
          NULL
          ["component"]=>
          string(10) "mod_choice"
        }
        ["coursecertificate"]=>
        object(core\plugininfo\mod)#1773 (20) {
          ["type"]=>
          string(3) "mod"
          ["typerootdir"]=>
          string(17) "/var/www/html/mod"
          ["name"]=>
          string(17) "coursecertificate"
          ["displayname"]=>
          string(18) "Course certificate"
          ["source"]=>
          string(3) "ext"
          ["rootdir"]=>
          string(35) "/var/www/html/mod/coursecertificate"
          ["versiondisk"]=>
          int(2025031804)
          ["versiondb"]=>
          string(10) "2025031804"
          ["versionrequires"]=>
          float(2022041900)
          ["pluginsupported"]=>
          array(2) {
            [0]=>
            int(400)
            [1]=>
            int(405)
          }
          ["pluginincompatible"]=>
          NULL
          ["release"]=>
          string(5) "4.5.7"
          ["dependencies"]=>
          array(1) {
            ["tool_certificate"]=>
            int(2025031804)
          }
          ["instances"]=>
          NULL
          ["sortorder"]=>
          NULL
          ["pluginman"]=>
          *RECURSION*
          ["availableupdates":protected]=>
          NULL
          ["supported"]=>
          NULL
          ["incompatible"]=>
          NULL
          ["component"]=>
          string(21) "mod_coursecertificate"
        }
        ["data"]=>
        object(core\plugininfo\mod)#1774 (20) {
          ["type"]=>
          string(3) "mod"
          ["typerootdir"]=>
          string(17) "/var/www/html/mod"
          ["name"]=>
          string(4) "data"
          ["displayname"]=>
          string(8) "Database"
          ["source"]=>
          string(3) "std"
          ["rootdir"]=>
          string(22) "/var/www/html/mod/data"
          ["versiondisk"]=>
          int(2024100700)
          ["versiondb"]=>
          string(10) "2024100700"
          ["versionrequires"]=>
          int(2024100100)
          ["pluginsupported"]=>
          NULL
          ["pluginincompatible"]=>
          NULL
          ["release"]=>
          NULL
          ["dependencies"]=>
          array(0) {
          }
          ["instances"]=>
          NULL
          ["sortorder"]=>
          NULL
          ["pluginman"]=>
          *RECURSION*
          ["availableupdates":protected]=>
          NULL
          ["supported"]=>
          NULL
          ["incompatible"]=>
          NULL
          ["component"]=>
          string(8) "mod_data"
        }
        ["feedback"]=>
        object(core\plugininfo\mod)#1775 (20) {
          ["type"]=>
          string(3) "mod"
          ["typerootdir"]=>
          string(17) "/var/www/html/mod"
          ["name"]=>
          string(8) "feedback"
          ["displayname"]=>
          string(8) "Feedback"
          ["source"]=>
          string(3) "std"
          ["rootdir"]=>
          string(26) "/var/www/html/mod/feedback"
          ["versiondisk"]=>
          int(2024100701)
          ["versiondb"]=>
          string(10) "2024100701"
          ["versionrequires"]=>
          int(2024100100)
          ["pluginsupported"]=>
          NULL
          ["pluginincompatible"]=>
          NULL
          ["release"]=>
          NULL
          ["dependencies"]=>
          array(0) {
          }
          ["instances"]=>
          NULL
          ["sortorder"]=>
          NULL
          ["pluginman"]=>
          *RECURSION*
          ["availableupdates":protected]=>
          NULL
          ["supported"]=>
          NULL
          ["incompatible"]=>
          NULL
          ["…