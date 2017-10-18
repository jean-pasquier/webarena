<?php $this->assign('title', 'Sight');?>
<?php
foreach(range(0, $width_x-1) as $width)
{
    foreach(range(0, $lenght_y-1) as $lenght)
    {
        echo('x');
    }
    ?> </br>
    <?php
}