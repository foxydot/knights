<div class="container-fluid post">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1><?php print $organization->meta['site_title']->meta_value != ''?$organization->meta['site_title']->meta_value:$organization->name; ?></h1>
            <?php print $organization->description; ?>
        </div>
    </div>
</div>