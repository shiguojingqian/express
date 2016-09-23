<?php
namespace Admin\Controller;

class FansUserController extends IndexController {
    
	// public function _initialize(){
		 // parent::_initialize();
    // }
    
    public function index(){
        $map['level'] = 1;
        $FansUserModel = M('FansUser');
        $FansUserList = $FansUserModel->where($map)->select();
        $this->assign('FansUserList',$FansUserList);
        $this->display();
    }

    public function express(){
        $FansUserModel = D('FansUser');
        $map['level'] = I('get.level');
        $FansUserList = $FansUserModel->relation(true)->where($map)->select();
        foreach($FansUserList as $k){
            if($k['Archives'] == NULL) unset($FansUserList[$k],$FansUserList);
        }
        $this->assign('FansUserList',$FansUserList);
        $this->assign('title',$map['level'] == 2 ? '配送员管理' : '配送员审核');
        $this->display();
    }

    public function details(){
        $this->assign('ArchivesInfo',M('Archives')->where(array('id'=>intval(I('get.id'))))->find());
        $this->display();
    }

    public function update(){
        if(IS_POST){
           $data['level'] = I('post.status') == 3 ? 1 : 2;
           $data['Archives'] = array(
                'status' => I('post.status'),
           );
           $FansUserModel = D('FansUser');
           D('FansUser')->relation(true)->where(array('id'=>I('post.id')))->save($data);
           $this->success('审核成功');
        }
    }
}