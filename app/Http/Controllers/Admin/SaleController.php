<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Coupone;
use App\Models\History;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session as FacadesSession;
use Spatie\Activitylog\Models\Activity;

class SaleController extends Controller
{
    public function list()
    {
        $sales = Sale::withTrashed("id", "desc")->search()->paginate(5);
        return view("admin.sales.list", compact("sales"))->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function add()
    {
        return view("admin.sales.add");
    }
    public function store(SaleRequest $request)
    {
        $code = $request->input("code");
        $discount = $request->input("discount");
        $count = $request->input("count");
        $typeDiscount = $request->input("typeDiscount");
        $start = $request->input("start");
        $end = $request->input("end");
        $status = $request->input("status");
        $event = $request->input("event");

        $sale = [
            'code' => $code,
            'discount' => $discount,
            'typeOfDiscount' => $typeDiscount,
            'count' => $count,
            'start' => $start,
            'end' => $end,
            'status'=> $status,
            'event'=> $event
        ];



        $code = Sale::create($sale);
        $user = User::all();
        foreach($user as $user ){
            Mail::send('emails.new_code_sale', compact('code'), function ($email) use ($user) {
                $email->to($user->email);
                $email->subject('Gửi tới khách hàng');
            });
        }
        $selectedStatus = $request->input("status");
      if($code){
          $newData = [
              'Id' => $code->id,
              'Mã code' => $code->code,
              'Giá trị' => $code->discount,
              'Kiểu giảm giá' => $code->typeOfDiscount,
              'Số lượng' => $code->count,
              'Ngày bắt đầu' => $code->start,
              'Ngày kết thúc' => $code->end,
              'Nội dung' => $code->event,
              'Trạng thái mã' => $selectedStatus
          ];
          Activity::create([
              'description' => 'Thêm mới',
              'subject_id' => $code->id,
              'subject_type' => Sale::class,
              'causer_id' => auth()->id(),
              'causer_type' => User::class,
              'new_data' => json_encode($newData),
          ]);
          return redirect()->route('sale.list');
      }
    }
    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        return view('admin.sales.edit', compact('sale'));
    }
    public function update(UpdateSaleRequest $request, $id)
    {

        $code = $request->input("code");
        $discount = $request->input("discount");
        $count = $request->input("count");
        $typeDiscount = $request->input("typeDiscount");
        $start = $request->input("start");
        $end = $request->input("end");
        $status = $request->input("status");
        $event = $request->input("event");
        $sale = Sale::find($id);
        $selectedStatus = $request->input("status");
        $oldData = [
            'Id' => $sale->id,
            'Mã code' => $sale->code,
            'Giá trị' => $sale->discount,
            'Kiểu giảm giá' => $sale->typeOfDiscount,
            'Số lượng' => $sale->count,
            'Ngày bắt đầu' => $sale->start,
            'Ngày kết thúc' => $sale->end,
            'Nội dung' => $sale->event,
            'Trạng thái mã' => $sale->status
        ];
        $sale->update([
            'code' => $code,
            'discount' => $discount,
            'typeOfDiscount' => $typeDiscount,
            'count' => $count,
            'start' => $start,
            'end' => $end,
            'status' => $status,
            'event'=> $event
        ]);
       if($sale->update()){
           $newData = [
               'Id' => $sale->id,
               'Mã code' => $sale->code,
               'Giá trị' => $sale->discount,
               'Kiểu giảm giá' => $sale->typeOfDiscount,
               'Số lượng' => $sale->count,
               'Ngày bắt đầu' => $sale->start,
               'Ngày kết thúc' => $sale->end,
               'Nội dung' => $sale->event,
               'Trạng thái mã' => $selectedStatus
           ];

           // Ghi log hoạt động ở đây
           if ($oldData !== $newData) {
               Activity::create([
                   'log_name' => 'default',
                   'description' => 'Cập nhật',
                   'subject_id' => $id,
                   'subject_type' => Sale::class,
                   'causer_id' => auth()->id(),
                   'causer_type' => User::class,
                   'old_data' => json_encode($oldData),
                   'new_data' => json_encode($newData),
               ]);
           }
           return redirect()->route('sale.list');
       }

    }
    public function destroy($id)
    {
        $sale = Sale::find($id);
        $sale->delete();
       if($sale->delete()){
           $oldData = [
               'Id' => $sale->id,
               'Mã code' => $sale->code,
               'Giá trị' => $sale->discount,
               'Kiểu giảm giá' => $sale->typeOfDiscount,
               'Số lượng' => $sale->count,
               'Ngày bắt đầu' => $sale->start,
               'Ngày kết thúc' => $sale->end,
               'Nội dung' => $sale->event,
               'Trạng thái mã' => $sale->status,
           ];
           Activity::create([
               'description' => 'Xóa',
               'subject_id' => $sale->id,
               'subject_type' => Sale::class,
               'causer_id' => auth()->id(),
               'causer_type' => User::class,
               'old_data' => json_encode($oldData),
           ]);
           return redirect()->route('sale.list');
       }
    }
    public function applyCode(Request $request)
    {
        date_default_timezone_set('Asia/Bangkok');
        $date = date('Y-m-d H:i:s');
        $code = $request->input('code');
        $check = DB::table('sales')->where('code', $code)->first();

        if ($check && $check->status == 1) {
            $checkfirst = Coupone::where('id_sale', $check->id)->where('id_user', Auth::user()->id)->first();

            if ($checkfirst) {
                $messes = 'Mã giảm giá đã được sử dụng';
            } else {
                if ($check->count == 0) {
                    $messes = 'Đã hết mã giảm giá';
                } else {
                    $priceDiscount = '';
                    if ($check->typeOfDiscount == "%") {
                        $priceDiscount = $check->discount / 100;
                    } else {
                        $priceDiscount = $check->discount;
                    }
                    if (strtotime($date) >= strtotime($check->start) && strtotime($date) <= strtotime($check->end)) {

                        $price = session()->get('discount', []);
                        $price = [
                            "id" => $check->id,
                            "code" => $check->code,
                            "sale" => $priceDiscount,
                            "type" => $check->typeOfDiscount,
                        ];
                        session()->put("discount", $price);
                        $messes = 'Apply success';
                    } elseif(strtotime($date) < strtotime($check->start) ){
                        $messes = 'Mã giảm giá chưa đến thời hạn sử dụng';
                    }elseif(strtotime($date) > strtotime($check->end)){
                        $messes = 'Mã giảm giá đã hết hạn';
                    }
                }
            }

        } else {
            $messes = 'Mã giảm giá không tồn tại';
        }


        return redirect()->back()->with('messes', $messes);
    }
    public function disCode()
    {
        session()->forget('discount');
        return redirect()->back()->with('messes', 'Đã bỏ mã giảm giá');
    }
    public function history()
    {
        $event = [
            'created' => 'Thêm mới',
            'updated' => 'Cập nhật',
            'deleted' => 'Xóa',
            'restored' => ' Khôi phục'
        ];
        $subject_type = [
            'App\Models\Sale' => ' Giảm giá',
        ];
        $his = History::where('subject_type', Sale::class, )->get();
        $users = User::all();
        $sale = Sale::withTrashed()->get();
        return view('admin.sales.history', compact('his', 'sale', 'users', 'event', 'subject_type'));
    }
    public function restore(string $id)
    {
        $sale = Sale::withTrashed()->find($id);

        if ($sale) {
            $sale->restore();
            $oldData = [
                'Id' => $sale->id,
                'Mã code' => $sale->code,
                'Giá trị' => $sale->discount,
                'Kiểu giảm giá' => $sale->typeOfDiscount,
                'Số lượng' => $sale->count,
                'Ngày bắt đầu' => $sale->start,
                'Ngày kết thúc' => $sale->end,
                'Nội dung' => $sale->event,
                'Trạng thái mã' => $sale->status,
            ];
            Activity::create([
                'description' => 'Khôi phục',
                'subject_id' => $sale->id,
                'subject_type' => Sale::class,
                'causer_id' => auth()->id(),
                'causer_type' => User::class,
                'old_data' => json_encode($oldData),
            ]);
            Session::flash('success', 'Khôi phục thành công');
            return redirect()->back();
        } else {
            Session::flash('error', 'Khôi phục lỗi - Bản ghi không tồn tại');
            return redirect()->back();
        }
    }

}
