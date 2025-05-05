<?php 
function renderComponent($view, $data = []) {
    extract($data); 
    include $view;
}
?>