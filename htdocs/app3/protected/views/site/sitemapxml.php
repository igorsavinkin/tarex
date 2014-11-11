<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>

<urlset
        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
                http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

<?php foreach($categories as $model): ?>
	<url>
	<loc><?php echo CHtml::encode($this->createAbsoluteUrl('assortment/index', array('Assortment[groupCategory]'=>$model->id, 'Subsystem'=>'Warehouse+automation', 'Reference'=>'Assortment'))); ?></loc>
	<changefreq>monthly</changefreq>
	<priority>0.5</priority>
	</url>
<?php endforeach; ?>

<?php foreach($makes as $model): ?>
	<url>
	<loc><?php echo CHtml::encode($this->createAbsoluteUrl('assortment/index', array('id'=>$model->id, 'Subsystem'=>'Warehouse+automation', 'Reference'=>'Assortment'))); ?></loc>
	<changefreq>weekly</changefreq>
	<priority>0.5</priority>
	</url>
<?php endforeach; ?>

<?php foreach($assortment as $model): ?>
	<url>
	<loc><?php echo CHtml::encode($this->createAbsoluteUrl('assortment/view', array('id'=>$model->id))); ?></loc>
	<changefreq>daily</changefreq>
	<priority>0.5</priority>
	</url>
<?php endforeach; ?>
</urlset>