
<?php
require_once __DIR__ . '/../Helpers/View.php';
require_once __DIR__ . '/../Repositories/UserRepository.php';

class DashboardController
{
    public function index()
    {
        $userRepo = new UserRepository();
        $user = $userRepo->findById($_SESSION['user_id']);
        View::render('dashboard/index', ['user' => $user]);
    }
}
