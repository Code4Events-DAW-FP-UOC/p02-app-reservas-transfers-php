<?php
class IndexController extends Controller{

    public function index(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        $this->view('index');
    }
}