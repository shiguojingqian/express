<?php
namespace Admin\Controller;

class RangesController extends IndexController {
    public function index(){
         !empty(I('get.search')) && $map['range_name'] = array('LIKE',"%".I('get.search')."%");
        $RangeList = M('ranges')->where($map)->select();
        $this->assign('RangeList',$RangeList);
        $this->display();
    }

    public function add(){
        $this->display();
    }

    public function insert(){
        if(IS_POST){
            $RangeModel = D('Ranges');
            !($RangeModel->create($_POST)) && $this->error($RangeModel->getError());
            $RangeModel->add($_POST) ? $this->success('添加成功') : $this->error('添加失败');
        }
    }

    public function edit(){
        $map['id'] = I('get.id');
        $RangeInfo = M('ranges')->where($map)->find();
        $this->assign('RangeInfo',$RangeInfo);
        $this->display();
    }

    public function update(){
        if(IS_POST){
            $RangeModel = D('Ranges');
            $map['id'] = I('post.id');
            $data['range_name'] = I('post.range_name');
            $data['ceo'] = I('post.ceo');
            $data['phone'] = I('post.phone');
            $data['status'] = I('post.status');
            !$RangeModel->where($map)->find() && $this->error('数据不存在');
            !($RangeModel->create($data,2)) && $this->error($RangeModel->getError());
            $RangeModel->where($map)->save($data) ? $this->success('修改成功') : $this->error('修改失败或未更新信息');
        }
    }
}