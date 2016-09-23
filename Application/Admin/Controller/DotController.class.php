<?php
namespace Admin\Controller;

class DotController extends IndexController {
    public function index(){
        $DotModel = M('dot');
        $DotList = $DotModel->where(array('status'=>1))->select();
        $this->assign('DotList',$DotList);
        $this->display();
    }

    public function add(){
        $this->display();
    }

    public function ajaxregion(){
        if(IS_POST){
            $RegionModel = M('region');
            $this->success($RegionModel->where(array('path'=>intval(I('post.id'))))->select());
        }
    }

    public function insert(){
        if(IS_POST){
            $DotModel = D('Dot');
            !($DotModel->create($_POST)) && $this->error($DotModel->getError());
            ($DotModel->add()) ? $this->success('添加成功') : $this->error('添加失败');
        }
    }

    public function edit(){
        $DotInfo = D('Dot')->where(array('id'=>I('get.id')))->find();
        $this->assign('DotInfo',$DotInfo);
        $this->display();
    }

    public function update(){
        if(IS_POST){
            $DotModel = D('Dot');
            !($DotModel->create($_POST)) && $this->error($DotModel->getError());
            ($DotModel->save()) ? $this->success('修改成功') : $this->error('修改失败或无更新');
        }
    }
}