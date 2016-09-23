<?php
namespace Admin\Controller;

class SettingController extends IndexController {

    public function index(){
        switch($_GET['status']){
            case 1:
                $title = '快递业务';
            break;
            case 2:
                $title = '寄件业务';
            break;
            case 3:
                $title = '外卖业务';
            break;
            default:
                $title = '无业务';
            break;
        }
        $this->assign('SettingInfo',M('setting')->where(array('status'=>$_GET['status']))->find());
        $this->assign('title',$title);
        $this->display();
    }

    public function insert(){
        if(IS_POST){
           $SettingModel = D('Setting');
           !($SettingModel->create($_POST)) && $this->error($SettingModel->getError());
           I('post.id') == '' ? $result = $SettingModel->add($_POST) : $result = $SettingModel->save($_POST);
           ($result >= 1) ? $this->success('更新成功') : $this->error('更新失败或未修改');
        }
    }

    public function tlist(){
        $this->assign('Times',M('times')->select());
        $this->display();
    }

    public function add(){
        $this->display();
    }

    public function timeinsert(){
        if(IS_POST){
           $TimesModel = M('times');
           !($_POST['time'] != '' && $_POST['price_time'] != '') && $this->error('请补全信息');
           ($TimesModel->add($_POST)) ? $this->success('添加成功') : $this->error('添加失败');
        }
    }

    public function edit(){
        $this->assign('TimesInfo',M('times')->where(array('id'=>I('id')))->find());
        $this->display();
    }

    public function update(){
        if(IS_POST){
           $TimesModel = M('times');
           !($_POST['time'] != '' && $_POST['price_time'] != '') && $this->error('请补全信息');
           ($TimesModel->save($_POST)) ? $this->success('修改成功') : $this->error('修改失败');
        }
    }

    public function reward(){
        $this->assign('RewardInfo',M('reward')->select());
        $this->display();
    }

    public function rewardadd(){
        $this->display();
    }

    public function rewardinsert(){
        if(IS_POST){
           $RewardModel = M('reward');
           !($_POST['condition'] != '' && $_POST['price'] != '') && $this->error('请补全信息');
           ($RewardModel->add($_POST)) ? $this->success('添加成功') : $this->error('添加失败');
        }
    }

    public function rewardupdate(){
        if(IS_POST){
           $RewardModel = M('reward');
           !($_POST['condition'] != '' && $_POST['price'] != '') && $this->error('请补全信息');
           ($RewardModel->save($_POST)) ? $this->success('修改成功') : $this->error('修改失败');
        }
    }

    public function rewardedit(){
        $this->assign('RewardInfo',M('reward')->where(array('id'=>I('id')))->find());
        $this->display();
    }

    public function timesize(){
        $this->assign('SettingInfo',M('setting')->where(array('status'=>$_GET['status']))->find());
        $this->display();
    }
}