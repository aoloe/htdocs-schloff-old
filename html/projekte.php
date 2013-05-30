<h1> Die Projekte </h1>

<?php foreach ($project as $key => $value) : ?>
<div class="projekte">
<?php if (empty($value['icon'])) : ?>
<img src="bild/pixel.png" alt="" style="border:1px dotted black;">
<?php else : ?>
<img src="bild/projekt/<?=  $value['icon'] ?>" alt="" style="border:1px dotted black;">
<?php endif; ?>
<div class="projekte_inhalt">
<p class="datum"><?= $value['date'] ?></p>
<h3><?= $value['title'] ?></h3>
<p class="beschreibung"><?= $value['description'] ?></p>
<p class="ort"><?= $value['place'] ?></p>
<?php if (!empty($value['link'])) : ?>
<p class="ort"><?= implode("<br />\n", $value['link']) ?></p>
<?php endif; ?>
</div>
</div>
<?php endforeach; ?>
