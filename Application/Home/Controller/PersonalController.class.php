<?php
namespace Home\Controller;

class PersonalController extends IndexController {
    protected $FansUserInfo = array();
    
    public function _initialize(){
        parent::_initialize();
        $this->FansUserInfo = session(C(HOME_SESSION));
        $this->assign('UserInfo',$this->FansUserInfo);
    }

    public function index(){
        $this->display();
    }

    public function address(){
        $this->display();
    }

    public function addressinsert(){
        if(IS_POST){
            
        }else{
            $this->display();
        }
    }

    public function agreement(){
        $UserInfo = D('FansUser')->relation(true)->where(array('openid'=>$this->FansUserInfo['openid']))->find();
        if($UserInfo['level'] == 1 && empty($UserInfo['Archives'])){
            $this->display();
        }else if($UserInfo['level'] == 2){
            $WagesModel = M('Wages');
            $this->assign('weijiesuan',$WagesModel->where(array('status'=>0,'user_id'=>$this->FansUserInfo['id']))->sum('total'));
            $this->assign('yijiesuan',$WagesModel->where(array('status'=>1,'user_id'=>$this->FansUserInfo['id']))->sum('total'));
            $this->assign('count',M('package')->where(array('user_id'=>$this->FansUserInfo['id']))->count());
            $this->assign('UserInfo',$UserInfo);
            $this->display('express');
        }else if($UserInfo['Archives']){
            $this->error('资料正在审核当中');
        }
    }

    public function registeredexpress(){
        if(IS_POST){
            $ArchivesModel = D('Archives');
            !($ArchivesModel->create($_POST)) && $this->error($ArchivesModel->getError());
            ($ArchivesModel->add()) ? $this->success('资料提交成功',U('Personal/index')) : $this->error('资料提交失败请联系管理员');
        }else{
            $UserInfo = D('FansUser')->relation(true)->where(array('openid'=>get_openid()))->find();
            !empty($UserInfo['Archives']) && $this->error('资料正在审核当中');
            $this->display();
        }
    }

    public function select(){
        $RegionModel = M('region');
        if(IS_POST){
            $this->success($RegionModel->where(array('path'=>intval(I('post.id'))))->select());
            exit;
        }
        $this->assign('RegionList',$RegionModel->where(array('path'=>0))->select());
        $this->display();
    }

    public function ajaxrange(){
        if(IS_POST){
            $this->success(M('ranges')->where(array('id'=>intval(I('post.id'))))->find());
        }
    }

    public function wages(){
        $where = array(
            'user_id'   =>  $this->FansUserInfo['id'],
            'createtime'=>  array('BETWEEN',array(strtotime(date("Y-01-01")),strtotime(date("Y-12-31")))),
        );
        $wagesList = M('wages')->where($where)->field('*,SUM(total) as total')->select();
        $List = array();
        foreach($wagesList as $key => $val){
            if($wagesList[$key]['id'] != NULL){
                $List[date("m",$wagesList[$key]['createtime'])] = $wagesList[$key];
                $total = $wagesList[$key]['total'];
            }else{
                unset($wagesList[$key],$wagesList);
            }
        }
        $this->assign('List',$List);
        $this->assign('total',$total);
        $this->display();
    }

    public function detailed(){
        $timea = date("Y-".$_GET['m']."-01");
        $timeb = date("Y-".$_GET['m']."-t");
        $where = array(
            'status'      =>  3,
            'edittime'    =>  array('BETWEEN',array(strtotime($timea),strtotime($timeb))),
        );
        $PackageModel = M('Package');
        $PackageList = $PackageModel->where($where)->order('edittime desc')->select();
        $PackageInfo = array();
        $total = array();
        $yertotal;
        foreach($PackageList as $key){
            $PackageInfo[date("m-d",$key['edittime'])][] = $key;
            $total[date("m-d",$key['edittime'])]['total'] += $key['price'];
            $yertotal += $key['price'];
        }
        $this->assign('PackageInfo',$PackageInfo);
        $this->assign('total',$total);
        $this->assign('yertotal',$yertotal);
        $this->display();
    }
}