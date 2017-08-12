<?php $location = "/therefore/here/" . $name . "/images"; ?>
<?php $locationParent = "/therefore/here/". $parent . "/" . $name . "/images"; ?>
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
<div class="content">
    <div id="scroller">
        <div class="images">
            <?php
            $numberOfImages = 9;
            for ($i = 1; $i <= $numberOfImages; $i++) {
                echo "<img src=\"{$location}/all-{$i}.png\" alt=\"\" width=\"1320\" height=\"993\" >";
            }
            ?>
        </div>
    </div>
</div>
