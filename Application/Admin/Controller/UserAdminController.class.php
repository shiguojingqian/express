<?php
namespace Admin\Controller;

class UserAdminController extends IndexController {
    
	// public function _initialize(){
		 // parent::_initialize();
    // }
    
    public function index(){
        $UserAdminModel = M('UserAdmin');
        $UserAdmin = $UserAdminModel->select();
        
        $this->assign('UserAdmin',$UserAdmin);
        $this->display();
    }

    public function add(){
        $this->assign('AuthGroupList',M('AuthGroup')->where(array('status'=>1))->select());
        $this->display();
    }

    public function insert(){
        if(IS_POST){
           $UserAdminModel = D('UserAdmin');
           !($UserAdminModel->create($_POST)) && $this->error($UserAdminModel->getError());
           empty(I('post.group_id')) && $this->error('请选择角色');
           $result = $UserAdminModel->add();
           ($result >= 1 && M('auth_group_access')->add(array('uid'=>$result,'group_id'=>I('post.group_id')))) ? $this->success('新增成功') : $this->error('新增失败');
        }
    }

    public function edit(){
        $this->assign('UserAdminInfo',M('UserAdmin')->where(array('id'=>I('get.id')))->find());
        $this->assign('AuthGroupList',M('AuthGroup')->where(array('status'=>1))->select());
        $this->display();
    }

    public function update(){
        if(IS_POST){
           $UserAdminModel = D('UserAdmin');
           !($UserAdminModel->where(array('id'=>intval(I('post.id'))))->find()) && $this->error('无此用户');
           !($UserAdminModel->create($_POST,2)) && $this->error($UserAdminModel->getError());
           ($UserAdminModel->save()) ? $this->success('修改成功') : $this->error('修改失败');
        }
    }

    public function rule(){
        if(IS_POST){
           (M('auth_group_access')->where(array('uid'=>I('post.id')))->save(array('group_id'=>I('post.group_id')))) ? $this->success('修改成功') : $this->error('修改失败');
        }else{
            $this->assign('UserAdminInfo',M('UserAdmin')->where(array('id'=>I('get.id')))->find());
            $this->assign('AuthGroupList',M('AuthGroup')->where(array('status'=>1))->select());
            $this->display();
        }
    }
}