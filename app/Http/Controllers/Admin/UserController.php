<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExportView;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateUserRequest;
use App\Http\Requests\Auth\EditUserRequest;
use App\Models\Author;
use App\Models\Customer;
use App\Models\History;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withTrashed('id', 'DESC')->search()->paginate(10);
        return view("admin.users.list", compact("users"));
    }
    public function filter(Request $request)
    {
        $role = $request->input('role');
        $searchInput = $request->input('searchInput');
        $usersQuery = User::query();

        // Lọc theo quyền
        if ($role) {
            $usersQuery->where('role', '=', $role);
        }
        // Tìm theo tên
        if ($searchInput) {
            $usersQuery->where('name', 'like', '%' . $searchInput . '%');
        }
        $users = $usersQuery->paginate(10);
        return view("admin.users.list", compact("users"));
    }
    public function createUser()
    {
        return view('admin.users.create');
    }
    public function createUserPost(CreateUserRequest $request)
    {

        $data['name'] = $request->name;
        $data['username'] = $request->username;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;

        if (Auth::user()->role == 1) {
            $data['role'] = $request->role;
        }

        $user = Customer::create($data);
        if ($user) {
            $newData = [
                'Id' => $user->id,
                'Tên' => $user->name,
                'Tên đăng nhập' => $user->username,
                'Email' => $user->email,
                'Mật khẩu' => $user->password,
                'Địa chỉ' => $user->address,
                'Số điện thoại' => $user->phone,

            ];
            Activity::create([
                'description' => 'Thêm mới',
                'subject_id' => $user->id,
                'subject_type' => User::class,
                'causer_id' => auth()->id(),
                'causer_type' => User::class,
                'new_data' => json_encode($newData),
            ]);
            return redirect(route('users.list'));
        };
        return redirect(route('users.create'));
    }
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit',  compact('user'));
    }
    public function editUserPost(EditUserRequest $request,  $id)
    {
        $user = User::find($id);
        $oldData = [
                'Id' => $user->id,
                'Tên' => $user->name,
                'Tên đăng nhập' => $user->username,
                'Email' => $user->email,
                'Địa chỉ' => $user->address,
                'Số điện thoại' => $user->phone,

        ];
        if ($request->isMethod('POST')) {
            $user->name = $request->name;
            $user->address = $request->address;
            $user->phone = $request->phone;
            if (Auth::user()->role === 1) {
                $user->role = $request->role;
            }
            $user->update();
            if ($user->update()) {
                $newData = [
                    'Id' => $user->id,
                    'Tên' => $user->name,
                    'Tên đăng nhập' => $user->username,
                    'Email' => $user->email,
                    'Địa chỉ' => $user->address,
                    'Số điện thoại' => $user->phone,

                ];

                // Ghi log hoạt động ở đây
                if ($oldData !== $newData) {
                    Activity::create([
                        'log_name' => 'default',
                        'description' => 'Cập nhật',
                        'subject_id' => $id,
                        'subject_type' => User::class,
                        'causer_id' => auth()->id(),
                        'causer_type' => User::class,
                        'old_data' => json_encode($oldData),
                        'new_data' => json_encode($newData),
                    ]);
                session::flash('success', 'Cập nhật thành công');
                return redirect()->route('users.list');
            } else {
                session::flash('error', 'Lỗi cập nhật');
            }
        }
    }
        }
    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        if ($user->delete()) {
            $oldData = [
                'Id' => $user->id,
                'Tên' => $user->name,
                'Tên đăng nhập' => $user->username,
                'Email' => $user->email,
                'Mật khẩu' => $user->password,
                'Địa chỉ' => $user->address,
                'Số điện thoại' => $user->phone,

            ];
            Activity::create([
                'description' => 'Xóa',
                'subject_id' => $user->id,
                'subject_type' => User::class,
                'causer_id' => auth()->id(),
                'causer_type' => User::class,
                'old_data' => json_encode($oldData),
            ]);
        return redirect()->route('users.list')
            ->with('success', 'Xóa tài khoản thành công');
            }
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
            'App\Models\User' => 'Tài khoản',
        ];
        $his = History::where('subject_type', User::class,)->get();
        $users = User::all();
        return view('admin.users.history', compact('his', 'users', 'event', 'subject_type'));
    }

    public function restore(string $id)
    {
        $users = User::withTrashed()->find($id);
        $users->restore();
        if ( $users->restore()) {
            $oldData = [
                'Id' => $users->id,
                'Tên' => $users->name,
                'Tên đăng nhập' => $users->username,
                'Email' => $users->email,
                'Mật khẩu' => $users->password,
                'Địa chỉ' => $users->address,
                'Số điện thoại' => $users->phone,

            ];
            Activity::create([
                'description' => 'Khôi phục',
                'subject_id' => $users->id,
                'subject_type' => User::class,
                'causer_id' => auth()->id(),
                'causer_type' => User::class,
                'old_data' => json_encode($oldData),
            ]);
            $users->update(['is_active', true]);
            Session::flash('success', 'Khôi phục thành công');
            return redirect()->back();
        } else {
            Session::flash('error', 'Khôi phục lỗi');
        }
    }
}
