<?php

function openProjectsList($location) {
  // Get list of projects
  $json = file_get_contents($location);
  // Decode JSON
  $array = json_decode($json, true);
  return $array;
}
function saveProjectsList($projectsArray, $location) {
  // Encode array to a json string, JSON_PRETTY_PRINT will format it
  $jsonString = json_encode($projectsArray, JSON_PRETTY_PRINT);
  // Open json projects file
  $fp = fopen($location, 'w');
  // Write string to json file
  fwrite($fp, $jsonString);
  // Close file
  fclose($fp);
}

// function replaceKey($array, $old_key, $new_key) {
//     $keys = array_keys($array);
//     if (false === $index = array_search($old_key, $keys)) {
//         throw new Exception(sprintf('Key "%s" does not exit', $old_key));
//     }
//     $keys[$index] = $new_key;
//     return array_combine($keys, array_values($array));
// }

function replaceKey($array, $newKey, $oldKey) {

  // if the value is not an array, then you have reached the deepest
  // point of the branch, so return the value
  if (!is_array($array)) return $array;

  $newArray = array(); // empty array to hold copy of subject
  foreach ($array as $key => $value) {

    // replace the key with the new key only if it is the old key
    $key = ($key == $oldKey) ? $newKey : $key;

    // add the value with the recursive call
    $newArray[$key] = replaceKey($value, $newKey, $oldKey);
  }
  return $newArray;
}
//createProject("Example Project", "Bingo");

/**
* Create New Project
*
* This function will create a project.
*
* Parameters:
*     ($projectName)   string      Not formated project name
*     ($parent)        string      Parent name, if empty, it will
*                                  be added as a top project
*
*/
function createProject($projectName, $parent) {

  // Get list of projects
  $json = file_get_contents(__DIR__ . '/../projects.json');

  // Decode JSON
  $arr = json_decode($json, true);
  //print_r($arr);

  $formatedProjectName = getFormatedName($projectName);
  $formatedParentName = getFormatedName($parent);


  if ($parent == "") {
    // if no parent is given
    // Create new array entry
    $arr[$projectName] = array(
      "Name" => $projectName,
      "name" => $formatedProjectName,
      "isPublic" => FALSE,
      "isParent" => FALSE,
      "isLastOfGroup" => FALSE,
    );

    $projectLocation = __DIR__ . '/../here/' . $formatedProjectName;
  } else {
    // Check if parent exists
    if (!array_key_exists($parent, $arr)) {
      // Create parent
      $arr[$parent] = array(
        "Name" => $parent,
        "name" => $formatedParentName,
        "isPublic" => FALSE,
        "isParent" => TRUE,
        "isLastOfGroup" => FALSE,
      );
    }
    // Project inside parent
    $arr[$parent][$projectName] = array(
      "Name" => $projectName,
      "name" => $formatedProjectName,
      "isPublic" => FALSE,
      "isParent" => FALSE,
      "isLastOfGroup" => FALSE,
    );

    $projectLocation = __DIR__ . '/../here/'. $formatedParentName . "/" . $formatedProjectName;

    // Create parent folder if it doesn't exist
    if (!file_exists(__DIR__ . '/../here/'. $formatedParentName)) {
      mkdir(__DIR__ . '/../here/'. $formatedParentName, 0777, true);
    }
  }

  // Create directory and copy contents of _template folder
  xcopy( __DIR__ . '/_template', $projectLocation , $permissions = 0755);

  // Get scss file contents
  $scssContent = file_get_contents($projectLocation . "/_scss/_template_style.scss");
  // Search for "project_name" and replace with $formatedNewName
  $newScss = str_replace("project_name", $formatedProjectName, $scssContent);
  file_put_contents($projectLocation . "/_scss/_template_style.scss", $newScss);

  // Rename files inside new project
  rename($projectLocation . "/js/_template_js.js", $projectLocation . "/js/" . $formatedProjectName . "_js.js");
  rename($projectLocation . "/_scss/_template_style.scss", $projectLocation . "/_scss/" . $formatedProjectName . "_style.scss");

  // Rename variables inside files [current_data.json]
  $jsonCurrent = file_get_contents($projectLocation . '/current_data.json');
  $arrCurrent = json_decode($jsonCurrent, true);
  // print_r($arrCurrent);

  // Change Name, name and leave parent empty
  $arrCurrent["Name"] = $projectName;
  $arrCurrent["name"] = $formatedProjectName;
  $arrCurrent["parent"] = $formatedParentName;

  // Save new file
  $jsonCurrentString = json_encode($arrCurrent, JSON_PRETTY_PRINT);
  $fp = fopen($projectLocation . '/current_data.json', 'w');
  fwrite($fp, $jsonCurrentString);
  fclose($fp);

  //print_r($arr);
  // Encode array to a json string, JSON_PRETTY_PRINT will format it
  $jsonString = json_encode($arr, JSON_PRETTY_PRINT);
  // echo $jsonString;
  // Open json projects file
  $fp = fopen(__DIR__ . '/../projects.json', 'w');
  // Write string to json file
  fwrite($fp, $jsonString);
  // Close file
  fclose($fp);
  echo "Project created\n\n";
  echo "Details:\n";
  echo "Name: " . $projectName . " [" . $formatedProjectName . "]\n";
  if ($parent) echo "Parent name: " . $parent . " [" . $formatedParentName . "]\n";
}
// http://www.paulund.co.uk/php-delete-directory-and-files-in-directory
function deleteFilesInFolder($target) {
  if(is_dir($target)){
    $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

    foreach( $files as $file )
    {
      deleteFilesInFolder( $file );
    }

    if (is_dir($target)) rmdir( $target );
  } elseif(is_file($target)) {
    unlink( $target );
  }
}
function updateProjectStatus($projectName, $parent, $newStatus) {
  // Get json file
  // $json = file_get_contents(__DIR__ . '/../projects.json');
  $json = file_get_contents(__DIR__ . '/../projects.json');
  // Decode JSON
  $arr = json_decode($json, true);

  // echo $projectName . "\n";
  // echo $parentProjectName . "\n";
  if( projectExists($projectName, $arr) ) {
    if ($parent == "") {
      echo "Project is: ";
      echo $arr[$projectName]["isPublic"] ? "Public\n" : "Not public\n";
      if ($arr[$projectName]["isPublic"] == $newStatus) {
        echo "This project has this status\n";
      } else {
        $arr[$projectName]["isPublic"] = $newStatus;
        echo "\"" . $projectName . "\" is now updated!\n";
      }
    } else {
      echo "Project is: ";
      echo $arr[$parent][$projectName]["isPublic"] ? "Public\n" : "Not public\n";
      $arr[$parent][$projectName]["isPublic"] = $newStatus;
      $projectStatus = $newStatus ? "public" : "not public";
      echo "\"" . $projectName . "\" is now " . $projectStatus . "!\n";
      // $arrCurrent["Parent"]["Name"]["isPublic"] = TRUE;
    }
  } else {
    echo "The project \"" . $projectName . "\" doesn't exist.\n";
    exit;
  }

  // Encode array to a json string, JSON_PRETTY_PRINT will format it
  $jsonString = json_encode($arr, JSON_PRETTY_PRINT);
  // echo $jsonString;
  // Open json projects file
  $fp = fopen(__DIR__ . '/../projects.json', 'w');
  // Write string to json file
  fwrite($fp, $jsonString);
  // Close file
  fclose($fp);
}

/**
* Get Formated Name
*
* This function will format a name replacing all spaces
* and special characters
*
* Parameters:
*     ($Name)          string      Not formated name
*
*/
function getFormatedName($Name) {
  $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A',
                              'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                              'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N',
                              'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                              'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a',
                              'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                              'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
                              'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                              'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b',
                              'ÿ'=>'y' );
  $FormatedName = $Name;
  $FormatedName = strtr( $FormatedName, $unwanted_array );
  $FormatedName = preg_replace( "/\r|\n/", "", $FormatedName );
  $FormatedName = rtrim($FormatedName, "_");
  $FormatedName = preg_replace("/\s+/", " ", $FormatedName);
  $FormatedName = str_replace(" ", "_", $FormatedName);
  $FormatedName = preg_replace("/[^A-Za-z0-9_]/","",$FormatedName);
  $FormatedName = strtolower($FormatedName);
  return $FormatedName;
}

/**
* Project Exists
*
* Check if project exists in the list as project or subproject
*
* Parameters:
*     ($Key)          string       Key to find
*     ($Array)         array       Array to look for key
*/
function projectExists($Key, $Array) {
  // is in base array?
  if (array_key_exists($Key, $Array)) {
    return true;
  }
  // check arrays contained in this array
  foreach ($Array as $element) {
    if (is_array($element)) {
      if (projectExists($Key, $element)) {
        return true;
      }
    }
  }
  return false;
}
function promptNameAndParentRequest($Name, $Parent) {
  if (!$Name) {
    // No argumentas are given
    $parentProjectName = promptParentRequest();
    echo "Project Name: ";
    $answer = fopen ("php://stdin","r");
    $projectName = fgets($answer);
    $projectName = preg_replace( "/\r|\n/", "", $projectName );

  } else if ($Name && !$Parent) {
    // Only Project Name is given
    echo "Project Name: ";
    echo $Name . "\n";
    $parentProjectName = promptParentRequest();
    $projectName = $Name;
    $projectName = preg_replace( "/\r|\n/", "", $projectName );

  } else if ($Parent) {
    // Project Name and Parent are given
    // echo "PROJECT NAME\n";
    // echo $argv[2] . "\n";
    // echo "PARENT NAME\n";
    // echo $argv[3] . "\n";
    $projectName = $Name;
    $parentProjectName = $Parent;
  }

  return array($projectName, $parentProjectName);
  // list($projectName, $parentProjectName) = promptNameAndParentRequest($argv[2], $argv[3]);
}
function promptParentRequest() {
  echo "Project has PARENT? Type 'y' or 'n' to continue: ";
  $answer = fopen ("php://stdin","r");
  $hasParent = fgets($answer);
  if ( trim($hasParent) == 'yes' || trim($hasParent) == 'y' ) {
    echo "Type PARENT Name: ";
    $answer = fopen ("php://stdin","r");
    $parentProjectName = fgets($answer);
    $parentProjectName = preg_replace( "/\r|\n/", "", $parentProjectName );
    return $parentProjectName;
  } else if ( trim($hasParent) == 'no' || trim($hasParent) == 'n' ) {
    $parentProjectName = "";
    return $parentProjectName;
  } else {
    echo $hasParent . " is not valid\n";
    exit;
  }
}

/**
* Copy a file, or recursively copy a folder and its contents
* @author      Aidan Lister <aidan@php.net>
* @version     1.0.1
* @link        http://aidanlister.com/2004/04/recursively-copying-directories-in-php/
* @param       string   $source    Source path
* @param       string   $dest      Destination path
* @param       string   $permissions New folder creation permissions
* @return      bool     Returns true on success, false on failure
*/
function xcopy($source, $dest, $permissions = 0755) {
  // Check for symlinks
  if (is_link($source)) {
    return symlink(readlink($source), $dest);
  }

  // Simple copy for a file
  if (is_file($source)) {
    return copy($source, $dest);
  }

  // Make destination directory
  if (!is_dir($dest)) {
    mkdir($dest, $permissions);
  }

  // Loop through the folder
  $dir = dir($source);
  while (false !== $entry = $dir->read()) {
    // Skip pointers
    if ($entry == '.' || $entry == '..') {
      continue;
    }

    // Deep copy directories
    xcopy("$source/$entry", "$dest/$entry", $permissions);
  }

  // Clean up
  $dir->close();
  return true;
}

/**
* List all projects in sass file as import
*/

function updateSassList() {
  // Get json file
  $json = file_get_contents(__DIR__ . '/../projects.json');
  // Decode JSON
  $arr = json_decode($json, true);

  $sassList = "";

  foreach ($arr as $project) {
    if ($project["name"] != "index" && $project["name"] != "newsletter") {
      if ($project["isParent"]) {
        $parentName = $project["name"];
        foreach ($project as $subProject) {
          if (is_array($subProject)) {
            $sassList = $sassList . "@import \"../here/" . $parentName . "/" . $subProject['name'] . "/_scss/" . $subProject['name'] . "_style.scss\"" .";\n";
          }
        }
        // $sassList = $sassList . $project["name"]
      } else {
        $sassList = $sassList . "@import \"../here/" . $project["name"] . "/_scss/" . $project["name"] . "_style.scss\"" .";\n";
      }
    }
  }

  // echo $sassList;
  file_put_contents(__DIR__ . "/../_sass/_projects.scss", $sassList);
}


?>
