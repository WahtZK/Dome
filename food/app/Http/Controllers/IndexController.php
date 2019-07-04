<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Model\CatModel;
use App\Http\Model\TimeModel;
use App\Http\Model\PriceModel;

class IndexController extends Controller
{
    public function index(){
        return view("index");
    }

    public function indexTwo(){
        //今天时间
        $time=date("Y-m-d",time());
        //昨天时间
        $qiantime=date("Y-m-d",strtotime("-1 day"));
        //本周时间
        $date=new \DateTime();
        $date->modify('this week');
        //本周第一天
        $first_day_of_week=$date->format('Y-m-d');
        $date->modify('this week +6 days');
        //本周最后一天
        $end_day_of_week=$date->format('Y-m-d');

        //本月时间
        $Fristmonth=date('Y-m-01',strtotime(date("Y-m-d")));

        $Lastmonth=date('Y-m-d', strtotime("$Fristmonth +1 month -1 day"));

        $thisData=PriceModel::where('insert_time','like','%'.$time.'%')->get(['p_price'])->toArray();
        $thiscount=PriceModel::where('insert_time','like','%'.$time.'%')->count();

        $qianData=PriceModel::where('insert_time','like','%'.$qiantime.'%')->get(['p_price'])->toArray();
        $qiancount=PriceModel::where('insert_time','like','%'.$qiantime.'%')->count();

        $weekData=PriceModel::WhereBetween('insert_time',[$first_day_of_week,$end_day_of_week])->get(['p_price'])->toArray();
        $weekcount=PriceModel::WhereBetween('insert_time',[$first_day_of_week,$end_day_of_week])->count();

        $monthData=PriceModel::WhereBetween('insert_time',[$Fristmonth,$Lastmonth])->get(['p_price'])->toArray();
        $monthcount=PriceModel::WhereBetween('insert_time',[$Fristmonth,$Lastmonth])->count();

        $Data=PriceModel::get(['p_price'])->toArray();
        $count=PriceModel::count();

        $thisPrice=$this->returnTime($thisData,'p_price');
        $qianPrice=$this->returnTime($qianData,'p_price');
        $weekPrice=$this->returnTime($weekData,'p_price');
        $monthPrice=$this->returnTime($monthData,'p_price');
        $Price=$this->returnTime($Data,'p_price');

        $data=[
            'thisPrice'=>$thisPrice,
            'qianPrice'=>$qianPrice,
            'weekPrice'=>$weekPrice,
            'monthPrice'=>$monthPrice,
            'thiscount'=>$thiscount,
            'qiancount'=>$qiancount,
            'weekcount'=>$weekcount,
            'monthcount'=>$monthcount,
            'Price'=>$Price,
            'count'=>$count
        ];
        return view("index2",['data'=>$data]);
    }

    
    public function returnTime(array $arr,string $where){
        $count=0;
        foreach ($arr as $key => $value) {
            $count+=$value[$where];
        }
        return $count;
    }

    public function articleList(){
        $priceData=PriceModel::get()->toArray();

        return view("article_list",['pricedata'=>$priceData]);
    }
    public function articleAdd(){
        $catData=CatModel::get()->toArray();

        $timeData=TimeModel::get()->toArray();

        return view("article_add",['catdata'=>$catData,'timedata'=>$timeData]);
    }
    public function articleAddDo(){
        $data=Input::post();
        $insertData=[
            'p_name'=>$data['con'],
            'p_price'=>$data['price'],
            'p_cat'=>$data['cat'],
            'p_time'=>$data['time'],
            'insert_time'=>date("Y-m-d H:i:s")
        ];
        $res=PriceModel::insert($insertData);
        if ($res) {  
            echo "<script>alert('添加成功');history.go(-1)</script>";
        }
    }
    
}