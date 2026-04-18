<?php
class ThankyouController extends Controller {
    public function index() {
        $data = [
            'msg' => $_SESSION['msg'] ?? ''
        ];
        unset($_SESSION['msg']);

        $this->view('thankyou/index', $data);
    }
}
