<?php
require_once '../db.php';
require_once '../models/Poll.php';
if (isset($_POST['option'])) {
    Poll::vote($_POST['option']);
}
$results = Poll::results();
$total = array_sum(array_column($results, 'votes'));
foreach ($results as $r) {
    $percent = $total ? round($r['votes'] * 100 / $total) : 0;
    $barClass = 'bg-primary';
    if ($r['option_name'] === 'Tốc độ') $barClass = 'bg-success';
    if ($r['option_name'] === 'Dịch vụ khách hàng') $barClass = 'bg-warning';
    echo '
    <div class="mb-2">
        <div class="d-flex justify-content-between">
            <span>'.$r['option_name'].'</span>
            <span>'.$percent.'%</span>
        </div>
        <div class="progress" style="height: 20px;">
            <div class="progress-bar '.$barClass.'" role="progressbar" style="width: '.$percent.'%;" aria-valuenow="'.$percent.'" aria-valuemin="0" aria-valuemax="100">'.$percent.'%</div>
        </div>
    </div>
    ';
}