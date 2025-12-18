<?php
require_once __DIR__ . '/../Helpers/View.php';

class DashboardController {
    public function index() {
        View::render('dashboard/index');
    }
}
