<?php $location = "/therefore/here/" . $name . "/images"; ?>
<?php $locationParent = "/therefore/here/". $parent . "/" . $name . "/images"; ?>
<div class="preloader">
    <div class="status">
        <p>Loading 500 images</p>
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
          $numberOfImages = 500;
          for ($i = 1; $i <= $numberOfImages; $i++) {
              $position = str_pad($i, 3, '0', STR_PAD_LEFT);
              echo "<img
              src=    \"{$locationParent}/drowning-language-i-{$position}-guillermo-gineste.jpeg\"
              alt=    \"drowning-language-i\"
              width=  \"506\"
              height= \"800\"
              class=  \"images__single\"
              >";
          }
          ?>
          <span class="numbers"></span>
      </div>
    </div>
</div>
