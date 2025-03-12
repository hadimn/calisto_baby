<?php
if (file_exists("../classes/database.php")) {
    echo "database.php exists!";
    include "../classes/database.php";
    if (class_exists("Database")) {
        echo "<br>Database class exists!";
    } else {
        echo "<br>Database class does not exist!";
    }

} else {
    echo "database.php does not exist!";
}
?>