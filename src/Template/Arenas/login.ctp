<?php $this->assign('title', 'Login');?>

<h1>Please login</h1>
<?= $this->Form->create();
        $this->Form->control("login");
        $this->Form->submit();
        $this->Form->end();
 ?>
<!--
<form onsubmit="return false;">
    <fieldset>
        <input type="text"/>
        <input type="password"/>
        <input type="submit" value="Login"/>
    </fieldset>
</form>
-->