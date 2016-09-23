<?php
namespace Admin\Controller;

class AuthRuleController extends IndexController {

    public function index(){
        $AuthRuleModel = M('AuthRule');
        $AuthRuleList = $AuthRuleModel->select();
        $this->assign('AuthRuleList',$AuthRuleList);
        $this->display();
    }

    public function add(){
        $this->display();
    }

    public function insert(){
        if(IS_POST){
           $AuthRuleModel = D('AuthRule');
           !($AuthRuleModel->create($_POST)) && $this->error($AuthRuleModel->getError());
           ($AuthRuleModel->add()) ? $this->success('新增成功') : $this->error('新增失败');
        }
    }

    public function edit(){
        $this->assign('AuthRuleInfo',M('AuthRule')->where(array('id'=>I('get.id')))->find());
        $this->display();
    }

    public function update(){
        if(IS_POST){
           $AuthRuleModel = D('AuthRule');
           !($AuthRuleModel->create($_POST)) && $this->error($AuthRuleModel->getError());
           ($AuthRuleModel->save()) ? $this->success('修改成功') : $this->error('修改失败');
        }
    }
}