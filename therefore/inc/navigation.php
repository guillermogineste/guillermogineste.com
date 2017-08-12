<?php
// define("PHP_ROOT", "/therefore/");
// Get json file
$json = file_get_contents(__DIR__ . '/../projects.json');
// Decode JSON
$arr = json_decode($json, true);

// Add Class to submenu
$subMenuIsClosed = ($parent == "" ? "submenu-is-closed" : "");
if ($name == "index") {
    echo "<nav class=\"navigation {$subMenuIsClosed}\">";
} else {
    echo "<nav class=\"navigation {$subMenuIsClosed} is-collapsed\">";
}
?>
    <div class="collapse navigation--collapse">
        <span class="collapse__icon"></span>
    </div>
    <ul class="primary-navigation">

<?php
// Print navigation
foreach ($arr as $key) {
    if ($key["name"] == 'index') {
        // Only Index item
        echo "<li class=\"menu-item--{$key['name']} menu-item\">";
        echo "<a href=\"". PHP_ROOT ."\">{$key["Name"]}</a>";
        echo "</li>";
    } else if ($key["isParent"] && $key["isPublic"]) {
        $isLast = isLastOfGroup($key['isLastOfGroup']);
        // Is active menu item
        $isActive = ($key["name"] == $parent ? "active" : "");
        // Menu items with children
        echo "<li class=\"menu-item--{$key['name']} menu-item menu-item--has-children {$isLast} {$isActive}\">";
        echo "<span>{$key['Name']}</span>";
        echo "<ul class=\"secondary-navigation\">";
        foreach ($key as $subKey) {
            if (is_array($subKey)) {
                // Is active menu item
                $isActive = ($subKey["name"] == $name ? "active" : "");
                $isLast = isLastOfGroup($subKey['isLastOfGroup']);
                if ($subKey['isPublic']) {
                    echo "<li class=\"menu-item--{$subKey['name']} menu-item {$isLast} {$isActive}\">";
                    echo "<a href=\"". PHP_ROOT ."here/{$key['name']}/{$subKey['name']}\">{$subKey["Name"]}</a>";
                    echo "</li>";
                }
            }
        }
        echo "</ul>";
        echo "</li>";
    } else if ($key["isPublic"] && $key["name"] != 'newsletter') {
        $isLast = isLastOfGroup($key['isLastOfGroup']);
        // Is active menu item
        $isActive = ($key["name"] == $name ? "active" : "");
        // Regular menu items
        echo "<li class=\"menu-item--{$key['name']} menu-item {$isLast} {$isActive}\">";
        echo "<a href=\"". PHP_ROOT ."here/{$key['name']}\">{$key["Name"]}</a>";
        echo "</li>";
    }

}
foreach ($arr as $key) {
    if ($key["name"] == 'newsletter'){
        // Is active menu item
        $isActive = ($key["name"] == $name ? "active" : "");
        // Only Newsletter item
        echo "<li class=\"menu-item--{$key['name']} menu-item {$isActive}\">";
        echo "<a href=\"". PHP_ROOT ."newsletter\">{$key["Name"]}</a>";
        echo "</li>";
    }
}

function isLastOfGroup($type) {
    if ($type) {
        return 'menu-item--is-last';
    } else {
        return '';
    }

}
?>
</ul>
</nav>
