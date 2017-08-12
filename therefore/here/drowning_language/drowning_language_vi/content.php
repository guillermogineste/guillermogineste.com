<?php $location = "/therefore/here/" . $name . "/images"; ?>
<?php $locationParent = "/therefore/here/". $parent . "/" . $name . "/images"; ?>
<div class="preloader">
  <div class="status">
    <p>Loading 100 images</p>
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
      $titleList = array(
        "man lying down",
        "dirt ground in racing circuit",
        "blue sky",
        "house in ruins",
        "waves in the ocean",
        "mountains in the horizon",
        "people falling",
        "man inside washing machine",
        "red floor",
        "racing circuit",
        "open door",
        "forest behind horse",
        "snowy mountain",
        "soldier running",
        "blue line",
        "green water in a port",
        "fire coming out of a door",
        "white bed",
        "yellow river in the amazonic jungle",
        "soldier crouching",
        "tank in the desert",
        "white horse",
        "dirty and rusty truck",
        "jungle on the sides of a river I",
        "pieces of broken glass",
        "snowy ground",
        "locker room",
        "tree falling",
        "burnt corpse",
        "blow torch against metal",
        "washing machine ",
        "bottle cases",
        "car in the water",
        "jungle on the sides of a river III",
        "man in the water",
        "people in a living room",
        "tram in a wide street",
        "pool from which a man comes out",
        "blue bed",
        "yellow and orange dust and sand",
        "coast from the air",
        "river in the amazonian jungle",
        "green car",
        "spinning mill for metal",
        "train seats",
        "containers in a port",
        "light at the end of tunnel",
        "buildings through a window",
        "man looking down",
        "jungle on the sides of a river II",
        "highway roads",
        "soldier eating rice",
        "soldier standing up",
        "soldier laying down",
        "white wall behind stairs",
        "blue crab",
        "man leaning",
        "trees far away",
        "man in pink suit",
        "shadows in the pavement",
        "woman masturbating",
        "teens in a mall",
        "fridge on stairs",
        "repair shop",
        "backlit shadows and reflections",
        "soldier in the desert",
        "lower part of a truck",
        "curved bridge",
        "lights in the rain",
        "dancer on a pole",
        "clouds in the sky",
        "lights at night",
        "neck of man",
        "melting metal spilled on a hill",
        "man falling",
        "furniture in a garden",
        "kayak falling in a pool",
        "vegetation in the jungle",
        "wet road",
        "man sitting on a bed",
        "jungle on the sides of a river IV",
        "man praying",
        "woman hands",
        "woman in a pool",
        "woman in girls room",
        "screaming faces",
        "beach umbrellas flying",
        "jumping mat",
        "highway signs",
        "space in red light",
        "jacket and hat",
        "corpse face up",
        "yellow surfboard",
        "man under oven",
        "wall in the sun",
        "street at night",
        "balloons in a party",
        "toroidal objects in a factory",
        "football players",
        "traffic light for trains"
      );

      $numberOfImages = 100;
      for ($i = 0; $i < $numberOfImages; $i++) {
        $position = str_pad($i, 3, '0', STR_PAD_LEFT);
        $title = ucfirst($titleList[$i]);
        echo "<figure class=\"images__single\">";
        echo "<img
        src=    \"{$locationParent}/drowning-language-vi-{$position}-guillermo-gineste.png\"
        alt=    \"drowning-language-vi\"
        width=  \"1131\"
        height= \"800\"
        class=  \"images__single__img\"
        >";
        echo "<figcaption class=\"images__single__caption\">{$title}</span>";
        echo "</figure>";
      }
      ?>
    </div>
  </div>
</div>
