<?php
$this->title = 'Admin';
?>
<div class="admin-default-index">
  <h1><?= $this->title ?></h1>
  <ul>
    <? foreach ($menu as $key => $item) { ?>
      <li>
        <a href="<?= $item['link'] ?>"><?= $item['name'] ?></a>
      </li>
    <? } ?>
  </ul>
</div>
