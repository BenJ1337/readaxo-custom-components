<?php
$rex_values_content = json_decode(rex_article_slice::getArticleSliceById($rex_slice_id)->getValue(1), true);
if ($rex_values_content != null) {
    echo '<ol>';
    foreach ($rex_values_content["bilder"] as $img) {
        echo '<li>';
        if (empty($img)) {
            echo 'Kein Bild';
        } else {
            echo '<img src="/media/' . $img . '">';
        }
        echo  '</li>';
    }
    echo '</ol>';
} else {
    echo 'null';
}
