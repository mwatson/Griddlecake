/* container class, don't forget to add a width */
.griddle { clear: both; }

/* this is where all the magic happens */
<?= implode("\n", $steps); ?>

<? if(!$thirds[33] || !$thirds[34]) { ?>

/* provided for three 'even' columns */
<? } ?>
<? if(!$thirds[33]) { ?>
.col33 { float: left; width: 33%; }
<? } ?>
<? if(!$thirds[34]) { ?>
.col34 { float: left; width: 34%; }
<? } ?>

/* if you need some basic gutters */
.space { padding: 0px 10px; }
.bigspace { padding: 0px 20px; }
