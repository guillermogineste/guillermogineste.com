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
<img class="origin" src="<?php echo $location; ?>/origin.jpg" alt="" />
<div class="content">

    <div id="scroller">
        <div class="container">
            <section>
                <div class="left-col">
                </div>
                <div class="center-col">
                    <img src="<?php echo $location; ?>/null-painting.jpg">
                </div>
                <div class="right-col">
                </div>
            </section>
            <section>
                <div class="left-col">
                    <span><img src="<?php echo $location; ?>/one-frame.jpg"></span>
                </div>
                <div class="center-col">
                    <img src="<?php echo $location; ?>/one-painting.jpg">
                </div>
                <div class="right-col">
                    <span><img src="<?php echo $location; ?>/one-diary-1.jpg"></span>
                    <span><img src="<?php echo $location; ?>/one-diary-2.jpg"></span>
                    <span><img src="<?php echo $location; ?>/one-diary-3.jpg"></span>
                </div>
            </section>
            <section>
                <div class="left-col">
                    <span><img src="<?php echo $location; ?>/two-frame.jpg"></span>
                </div>
                <div class="center-col">
                    <img src="<?php echo $location; ?>/two-painting.jpg">
                </div>
                <div class="right-col">
                    <span><img src="<?php echo $location; ?>/two-diary-1.jpg"></span>
                    <span><img src="<?php echo $location; ?>/two-diary-2.jpg"></span>
                    <span><img src="<?php echo $location; ?>/two-diary-3.jpg"></span>
                </div>
            </section>
            <section>
                <div class="left-col">
                    <span><img src="<?php echo $location; ?>/three-frame.jpg"></span>
                </div>
                <div class="center-col">
                    <img src="<?php echo $location; ?>/three-painting.jpg">
                </div>
                <div class="right-col">
                    <span><img src="<?php echo $location; ?>/three-diary-1.jpg"></span>
                    <span><img src="<?php echo $location; ?>/three-diary-2.jpg"></span>
                    <span><img src="<?php echo $location; ?>/three-diary-3.jpg"></span>
                </div>
            </section>

        </div>
    </div>
</div>
