<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Freeship;
use App\Models\Quanhuyen;
use App\Models\Tinhtp;
use App\Models\Xaphuong;

use Illuminate\Http\Request;

class FreeshipController extends Controller
{
    public function index(){
        $tinhtp = Tinhtp::all();
        $quanhuyen = Quanhuyen::all();
        $xaphuong = Xaphuong::all();
        $ships = Freeship::paginate(10);
        return view('admin.freeship.list',compact('tinhtp','quanhuyen','xaphuong','ships'));
    }
    public function list(){
        $freeships = Freeship::orderby('id','DESC')->get();
        $output = '';
        $output.='
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <form action="" role="form">
                            <div class="input-group input-group" style="width: 350px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Tìm theo tên tác giả">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <strong>Tìm kiếm</strong>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">Tên Tỉnh/ Thành phố</th>
                                <th width="80">Tên Quận huyện</th>
                                <th width="80">Tên Xã phường</th>
                                <th width="80">Tên Phí ship</th>
                            </tr>
                        </thead>
                        <tbody>';
                            foreach ($freeships as $ship){
                                $output .= '
                            <tr>
                                <td>'.$ship->city->name.'</td>
                                <td>'.$ship->province->name.'</td>
                                <td>'.$ship->wards->name.'</td>
                                <td contenteditable data-freeship_id="'.$ship->id.'" class="freeship-edit">'.number_format($ship->price,0,',','.').' </td>
                            </tr>';
                            };
        $output .= '    </tbody>
                    </table>
                </div>
            </div>';
        echo $output;

    }
    public function create(Request $request){
        $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action']=="city"){
                $output .= '<option value="">----Chọn----</option>' ;
                $quanhuyen = Quanhuyen::where('id_tp','=',$data['id_tp'])->get();
                foreach($quanhuyen as $quan){
                    $output .= '<option value="'.$quan->id .'">'.$quan->name .'</option>' ;
                }
            }else{
                $output .= '<option value="">----Chọn----</option>' ;
                $xaphuong = Xaphuong::where('id_qh','=',$data['id_tp'])->get();
                foreach($xaphuong as $quan){
                    $output .= '<option value="'.$quan->id .'">'.$quan->name .'</option>' ;
                }
            }
        }
        echo $output;
    }
    public function add(Request $request){
        $data = $request->all();
        $freeship = new Freeship();
        
        $freeship->id_tp = $data['city'];
        $freeship->id_qh = $data['province'];
        $freeship->id_xa = $data['wards'];
        $freeship->price = $data['ship'];

        $freeship->save();
    }
    public function edit(Request $request){
        $data = $request->all();

        $freeship = Freeship::find($data['freeship_id']);
        $value = rtrim($data['freeship_value'],'.');
        $freeship->price = $value;

        $freeship->save();
    }
}
