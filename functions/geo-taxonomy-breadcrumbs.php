<?php
if (function_exists('yoast_breadcrumb') && (is_tax('geo_taxonomy') || is_tax('geo'))) {
    yoast_breadcrumb('<nav class="breadcrumbs">', '</nav>');
}
