<div class="preloader">
    <div class="status">
        <p>Loading</p>
        <p class="loading"><span>&#149;</span><span>&#149;</span><span>&#149;</span></p>
    </div>
</div>
<div class="drag-to-move">
    <img class="drag-to-move__icon" src="/therefore/img/hand_icon_ud@2x.png" width="43" height="43" alt="Drag to move in any direction" />
    <span class="drag-to-move__text">Drag to move</span>
</div>
<!-- <div class="preloader"><div class="status">Loading 87</div></div> -->
<?php $location = "/therefore/here/" . $name . "/images"; ?>
<?php $locationParent = "/therefore/here/". $parent . "/" . $name . "/images"; ?>
<div class="content">
    <div id="scroller">
        <div class="images">
            <!-- For lopp 1 , 01 to 25-->
            <?php
            for ($i = 1; $i <= 25; $i++) {
                $position = str_pad($i, 2, '0', STR_PAD_LEFT);
                echo "<section>" . "<div class=\"image_pair_container\">";
                echo "<img class=\"top\" with=\"400\" height=\"300\" src=\"{$locationParent}/{$position}a.jpg\">";
                echo "<img class=\"bottom\" with=\"400\" height=\"300\" src=\"{$locationParent}/{$position}b.jpg\">";
                echo "</div>" . "</section>";
            }
            ?>
            <img src="<?php echo $locationParent; ?>/dibujo_perspectiva.png" with="400" height="2862">

            <!-- For loop 2 , 26 to 50 -->
            <?php
            for ($i = 26; $i <= 50; $i++) {
                $position = str_pad($i, 2, '0', STR_PAD_LEFT);
                echo "<section>" . "<div class=\"image_pair_container\">";
                echo "<img class=\"top\" with=\"400\" height=\"300\" src=\"{$locationParent}/{$position}a.jpg\">";
                echo "<img class=\"bottom\" with=\"400\" height=\"300\" src=\"$locationParent/{$position}b.jpg\">";
                echo "</div>" . "</section>";
            }
            ?>
        </div>
    </div>
</div>
