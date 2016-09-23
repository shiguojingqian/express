<?php
namespace Admin\Controller;

class RegionController extends IndexController {
    public function index(){
        !empty(I('get.search')) && $mapa['rrsd_region.city'] = $map['city'] = array('LIKE',"%".I('get.search')."%");
        $mapa['rrsd_region.level'] = $map['level'] = I('get.level') ? I('get.level') : 1;
        $mapa['rrsd_region.path'] = $map['path'] = I('get.path') ? I('get.path') : 0;
        switch($map['level']){
            case 1:
                $title = '市';
            break;
            case 2:
                $title = '区/县';
            break;
            case 3:
                $title = '镇';
            break;
            case 4:
                $title = '村';
            break;
            default:
                $title = '没有了。。。。';
            break;
        }
        $RegionList = M('region')->join('LEFT JOIN rrsd_ranges ON rrsd_ranges.id = rrsd_region.range_id')->field('rrsd_region.*,rrsd_ranges.range_name')->where($mapa)->select();
        $this->assign('title',$title);
        $this->assign('map',$map);
        $this->assign('RegionList',$RegionList);
        $this->display();
    }

    public function add(){
        if(IS_POST){
            $this->success(M('emsaddress')->where(array('parentid'=>I('post.id')))->select());
        }
        I('get.ems_id') == '' ? $where = array('level'=>2) : $where = array('parentid'=>I('get.ems_id'));
        // dump(M('emsaddress')->where($where)->select());
        $this->assign('EMS',M('emsaddress')->where($where)->select());
        $this->assign('RangeList',M('ranges')->where(array('status'=>1))->field('id,range_name')->select());
        $this->display();
    }

    public function insert(){
        if(IS_POST){
           $RegionModel = D('Region');
           !($RegionModel->create($_POST)) && $this->error($RegionModel->getError());
           $RegionModel->add($_POST) ? $this->success('添加成功') : $this->error('添加失败');
        }
    }

    public function edit(){
        $map['id'] = I('get.id');
        $RegionInfo = M('region')->where($map)->find();
        $this->assign('RangeList',M('ranges')->where(array('status'=>1))->field('id,range_name')->select());
        $this->assign('RegionInfo',$RegionInfo);
        $this->display();
    }

    public function update(){
        if(IS_POST){
            $RegionModel = D('Region');
            $map['id'] = I('post.id');
            $map['level'] = I('post.level');
            $data['city'] = I('post.city');
            if(!empty(I('post.range_id')))
                $data['range_id'] = I('post.range_id');
            $data['status'] = I('post.status');
            !$RegionModel->where($map)->find() && $this->error('数据不存在');
            !($RegionModel->create($data,2)) && $this->error($RegionModel->getError());
            $RegionModel->where($map)->save($data) ? $this->success('修改成功') : $this->error('修改失败或未更新信息');
        }
    }
}