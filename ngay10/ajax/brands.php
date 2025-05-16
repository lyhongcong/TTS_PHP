<?php
$category = $_GET['category'] ?? '';
$xml = simplexml_load_file('../brands.xml');
$options = '';
foreach ($xml->brand as $brand) {
    if ((string)$brand['category'] === $category) {
        $options .= "<option value=\"{$brand}\">{$brand}</option>";
    }
}
echo $options;