<?php
class View {
    public static function render($path) {
        require __DIR__ . "/../../views/$path.php";
    }
}

