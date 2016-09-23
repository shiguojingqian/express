<?php
namespace Admin\Controller;

class AuthGroupController extends IndexController {

    public function index(){
        $AuthGroupModel = M('AuthGroup');
        $AuthGroupList = $AuthGroupModel->select();
        $this->assign('AuthGroupList',$AuthGroupList);
        $this->display();
    }

    public function add(){
        $this->assign('AuthRuleList',M('AuthRule')->where(array('status'=>1))->select());
        $this->display();
    }

    public function insert(){
        if(IS_POST){
           $AuthGroupModel = D('AuthGroup');
           $_POST['rules'] = implode(',',$_POST['rules']);
           !($AuthGroupModel->create($_POST)) && $this->error($AuthGroupModel->getError());
           ($AuthGroupModel->add()) ? $this->success('新增成功') : $this->error('新增失败');
        }
    }

    public function edit(){
        $this->assign('AuthGroupInfo',M('AuthGroup')->where(array('id'=>I('get.id')))->find());
        $this->assign('AuthRuleList',M('AuthRule')->where(array('status'=>1))->select());
        $this->display();
    }

    public function update(){
        if(IS_POST){
           $AuthGroupModel = D('AuthGroup');
           $_POST['rules'] = implode(',',$_POST['rules']);
           !($AuthGroupModel->create($_POST)) && $this->error($AuthGroupModel->getError());
           ($AuthGroupModel->save()) ? $this->success('修改成功') : $this->error('修改失败或无更新');
        }
    }
}