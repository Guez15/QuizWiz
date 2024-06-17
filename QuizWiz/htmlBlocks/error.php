<?php
    if(array_key_exists("errore",$_GET)){
        ?>
        <div class='error'>
            <h3 style="color: var(--rossoChiaro)"><?= $_GET['errore']?></h3>
        </div>
        <?php
    }
