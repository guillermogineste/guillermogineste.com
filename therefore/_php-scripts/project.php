#!/usr/bin/php
<?php
include 'functions.php';

// HELP
if (!$argv[1] || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
?>

    ----------------------------------------------------------------------------
    PROJECT EDITOR

    Usage:
    <?php echo $argv[0]; ?> <option> <Project Name> <Parent Name>

    <option>
    --help, -help, -h or -?       Opens this help
    --new, -new, -n               Creates new project
    --delete, -del, -d            Delete an existing project
    --rename, -rnm, -r            Rename an existing project
    --publish, -pub, -p           Publish a project (visble in the menu)
    --unpublish, -upub, -up       Unpublish a project (not visible in the menu)

    --list, -ls                   List all projects

    <Project Name>
    Readable project name in quotes: "This Is An Example".
    If not given the editor will ask for it.

    <Parent Name>
    Parent project name in quotes.
    If not given the editor will ask for it.

    ----------------------------------------------------------------------------

<?php
} else if ( in_array($argv[1], array('--new', '-new', '-n')) ){
    echo "\n----------------------------------------------------------------------------\n";
    echo "CREATE NEW PROJECT\n\n";

    // Ask for Name and Parent
    list($projectName, $parentProjectName) = promptNameAndParentRequest($argv[2], $argv[3]);

    // CREATE PROJECT
    createProject($projectName, $parentProjectName);

    // Update list of projects in sass file
    updateSassList();

} else if ( in_array($argv[1], array('--delete', '-del', '-d')) ){
    echo "\n----------------------------------------------------------------------------\n";
    echo "DELETE PROJECT\n\n";

    // Ask for Name and Parent
    list($projectName, $parentProjectName) = promptNameAndParentRequest($argv[2], $argv[3]);

    $formatedProjectName = getFormatedName($projectName);
    $formatedParentName = getFormatedName($parentProjectName);

    // Get list of projects
    $json = file_get_contents(__DIR__ . '/../projects.json');
    //$json = file_get_contents(__DIR__ . '/../projects.json');
    $arr = json_decode($json, true);
    //print_r($arr);

    //print_r($arr[$projectName]["Name"]);
    //echo $arr[$projectName]["Name"];

    if (projectExists($projectName, $arr)) {
        echo "Type DELETE to confirm: ";
        $answer = fopen ("php://stdin","r");
        $delete = fgets($answer);
        $delete = preg_replace( "/\r|\n/", "", $delete );
        if ( in_array($delete, array("delete", "Delete", "DELETE")) ) {
            if(!$parentProjectName) {
                echo $arr[$projectName]["Name"] . " ";
                // Remove entry from array
                unset($arr[$projectName]);

                $projectLocation = __DIR__ . '/../here/' . $formatedProjectName;
                // echo $projectLocation;
                deleteFilesInFolder($projectLocation);
            } else {
                echo $arr[$parentProjectName][$projectName]["Name"] . " ";
                // Remove entry from array
                unset($arr[$parentProjectName][$projectName]);

                $projectLocation = __DIR__ . '/../here/'. $formatedParentName . "/" . $formatedProjectName;
                // echo $projectLocation;
                deleteFilesInFolder($projectLocation);
            }
            echo "Project Deleted.\n";
        } else {
            echo "Project not deleted, please try again.";
        }
    } else {
        echo "Project: " . $projectName . " doesn't exist.\n";
    }

    // Encode array to a json string, JSON_PRETTY_PRINT will format it
    $jsonString = json_encode($arr, JSON_PRETTY_PRINT);
    // Open json projects file
    $fp = fopen(__DIR__ . '/../projects.json', 'w');
    // Write string to json file
    fwrite($fp, $jsonString);
    // Close file
    fclose($fp);

    // Update list of projects in sass file
    updateSassList();


} else if ( in_array($argv[1], array('--rename', '-rnm', '-r')) ){
    echo "\n----------------------------------------------------------------------------\n";
    echo "RENAME PROJECT\n\n";

    $projectsList = openProjectsList(__DIR__ . '/../projects.json');
    // Ask for Name and Parent
    list($projectName, $parentProjectName) = promptNameAndParentRequest($argv[2], $argv[3]);

    $formatedProjectName = getFormatedName($projectName);
    $formatedParentName = getFormatedName($parentProjectName);

    // echo $projectName . " [" . $formatedProjectName . "]";
    // echo $parentProjectName . " [" . $formatedParentName . "]";

    echo "New name: ";
    $answer = fopen ("php://stdin","r");
    $newName = fgets($answer);
    $newName = preg_replace( "/\r|\n/", "", $newName );

    $formatedNewName = getFormatedName($newName);

    if ( projectExists($projectName, $projectsList ) && !projectExists($newName, $projectsList )) {

        if ($parentProjectName == "") {
            $projectsList[$projectName]["Name"] = $newName;
            $projectsList[$projectName]["name"] = $formatedNewName;

            $projectLocation = __DIR__ . '/../here/' . $formatedProjectName;
            $newProjectLocation = __DIR__ . '/../here/' . $formatedNewName;
        } else {
            $projectsList[$parentProjectName][$projectName]["Name"] = $newName;
            $projectsList[$parentProjectName][$projectName]["name"] = $formatedNewName;

            $projectLocation = __DIR__ . '/../here/'. $formatedParentName . "/" . $formatedProjectName;
            $newProjectLocation = __DIR__ . '/../here/'. $formatedParentName . "/" . $formatedNewName;
        }

        if ($projectsList[$projectName]["isParent"]) {
            // If project is parent:

            foreach ($projectsList[$projectName] as $subProject) {
                if (is_array($subProject)) {
                    $subProjectFormatedName = $subProject["name"];
                    echo $subProjectFormatedName;
                    $dataLocation = __DIR__ . '/../here/'. $formatedProjectName . "/" . $subProjectFormatedName;

                    $jsonCurrent = file_get_contents($dataLocation . '/current_data.json');
                    $arrCurrent = json_decode($jsonCurrent, true);
                    $arrCurrent["parent"] = $formatedNewName;

                    // Save new file
                    $jsonCurrentString = json_encode($arrCurrent, JSON_PRETTY_PRINT);
                    $fp = fopen($dataLocation . '/current_data.json', 'w');
                    fwrite($fp, $jsonCurrentString);
                    fclose($fp);
                }
            }
        } else {
            // If it is a regular project:

            // Rename variables inside files [current_data.json]
            $jsonCurrent = file_get_contents($projectLocation . '/current_data.json');
            $arrCurrent = json_decode($jsonCurrent, true);

            // Change "Name" and "name"
            $arrCurrent["Name"] = $newName;
            $arrCurrent["name"] = $formatedNewName;

            // Save new file
            $jsonCurrentString = json_encode($arrCurrent, JSON_PRETTY_PRINT);
            $fp = fopen($projectLocation . '/current_data.json', 'w');
            fwrite($fp, $jsonCurrentString);
            fclose($fp);

            // Get scss file contents
            $scssContent = file_get_contents($projectLocation . "/_scss/" . $formatedProjectName . "_style.scss");
            // Search for "project_name" and replace with $formatedNewName
            $newScss = str_replace($formatedProjectName, $formatedNewName, $scssContent);
            file_put_contents($projectLocation . "/_scss/" . $formatedProjectName . "_style.scss", $newScss);

            // Rename .scss
            rename($projectLocation . "/_scss/" . $formatedProjectName . "_style.scss", $projectLocation . "/_scss/" . $formatedNewName . "_style.scss");
        }

        // Change key in projects list
        $projectsList = replaceKey($projectsList, $newName, $projectName);


        // Rename project folder
        rename($projectLocation, $newProjectLocation);

        echo "\nProject renamed to: " . $newName . " [" . $formatedNewName .  "]\n\n";

    } else if ( projectExists($newName, $projectsList ) ){
        echo "There is already a project with name \"" . $projectName . "\", try again with a different name.\n";
        exit;
    } else {
        echo "The project \"" . $projectName . "\" doesn't exist.\n";
        exit;
    }

    saveProjectsList($projectsList, __DIR__ . '/../projects.json');

    // Update list of projects in sass file
    updateSassList();

} else if ( in_array($argv[1], array('--publish', '-pub', '-p' )) ) {
    echo "\n----------------------------------------------------------------------------\n";
    echo "PUBLISH PROJECT\n\n";

    // var_dump($arr);

    // list($projectName, $parentProjectName) = promptNameAndParentRequest($argv[2], $argv[3]);

    if (!$argv[2]) {
        // No argumentas are given
        $parentProjectName = promptParentRequest();
        echo "Type Project Name: ";
        $answer = fopen ("php://stdin","r");
        $projectName = fgets($answer);
        $projectName = preg_replace( "/\r|\n/", "", $projectName );

    } else if ($argv[2] && !$argv[3]) {
        // Only Project Name is given
        echo "Project Name: ";
        echo $argv[2] . "\n";
        $parentProjectName = promptParentRequest();
        $projectName = $argv[2];

    } else if ($argv[3]) {
        // Project Name and Parent are given
        // echo "PROJECT NAME\n";
        // echo $argv[2] . "\n";
        // echo "PARENT NAME\n";
        // echo $argv[3] . "\n";
        $projectName = $argv[2];
        $parentProjectName = $argv[3];
    }

    $newStatus = TRUE;
    updateProjectStatus($projectName, $parentProjectName, $newStatus);

} else if ( in_array($argv[1], array('--unpublish', '-upub', '-up' )) ) {
    echo "\n----------------------------------------------------------------------------\n";
    echo "UNPUBLISH PROJECT\n\n";

    if (!$argv[2]) {
        // No argumentas are given
        $parentProjectName = promptParentRequest();
        echo "Type Project Name: ";
        $answer = fopen ("php://stdin","r");
        $projectName = fgets($answer);
        $projectName = preg_replace( "/\r|\n/", "", $projectName );

    } else if ($argv[2] && !$argv[3]) {
        // Only Project Name is given
        echo "Project Name: ";
        echo $argv[2] . "\n";
        $parentProjectName = promptParentRequest();
        $projectName = $argv[2];

    } else if ($argv[3]) {
        // Project Name and Parent are given
        // echo "PROJECT NAME\n";
        // echo $argv[2] . "\n";
        // echo "PARENT NAME\n";
        // echo $argv[3] . "\n";
        $projectName = $argv[2];
        $parentProjectName = $argv[3];
    }

    $newStatus = FALSE;
    updateProjectStatus($projectName, $parentProjectName, $newStatus);

} else if ( in_array($argv[1], array('--list', '-ls')) ){
    echo "\n----------------------------------------------------------------------------\n";
    echo "PROJECTS LIST\n\n";

    // Get json file
    $json = file_get_contents(__DIR__ . '/../projects.json');
    // Decode JSON
    $arr = json_decode($json, true);

    // var_dump($arr);
    // print_r($arr);

    foreach ($arr as $project) {
        // Add bullet depending if project is public
        $isPublic = ($project["isPublic"] ? "• " : "◦ " );
        if ($project["name"] != index) {
            // Print Project information: Bullet Name [name]
            echo $isPublic . $project['Name'] . " [" . $project['name'] . "]\n";
            // Create space if is last of group
            $isLastOfGroup = ($project["isLastOfGroup"] ? "\n" : "" );
            echo $isLastOfGroup;
            if ($project["isParent"]) {
                // Print subprojects
                foreach ($project as $subProject) {
                    if (is_array($subProject)) {
                        // Add bullet depending if project is public and indent
                        $isPublic = ($subProject["isPublic"] ? "    • " : "    ◦ ");
                        // Print Project information: Bullet Name [name]
                        echo $isPublic . $subProject['Name'] . " [" . $subProject['name'] . "]\n";
                        // Create space if is last of group
                        $isLastOfGroup = ($subProject["isLastOfGroup"] ? "\n" : "" );
                        echo $isLastOfGroup;
                    }
                }
            }
        }
    }

    echo "\n";
} else {
    echo "Invalid option\n";
}

echo "----------------------------------------------------------------------------\n\n";
exit;
?>
