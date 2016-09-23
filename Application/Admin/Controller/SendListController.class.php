<?php
namespace Admin\Controller;

class SendListController extends IndexController {

    public function index(){
        $SendModel = M('Send');
        $SendList = $SendModel->where()->select();
        $this->assign('SendList',$SendList);
        $this->display();
    }

}