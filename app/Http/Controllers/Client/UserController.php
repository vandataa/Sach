<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePassRequest;
use App\Http\Requests\Auth\MyAccountRequest;
use App\Http\Requests\Auth\ResetPassRequest;
use App\Http\Requests\Auth\SigninRequest;
use App\Http\Requests\Auth\SignupRequest;
use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session as FacadesSession;

class UserController extends Controller
{
    // Login
    public function signin()
    {
        $cate = Category::all();
        $auth = Author::all();
        $publishers = Publisher::all();
        return view('client/customer/signin', ['publishers' => $publishers,'auth' => $auth, 'cate' => $cate]);
    }
    public function signinPost(SigninRequest $request)
    {
        $user = $request->only('username', 'password');
        $existingUser = User::where('username', $user['username'])->first();
        if ($existingUser) {
            // Tài khoản tồn tại
            if (Auth::attempt($user)) {
                return redirect()->route('home');
            } else {
                $error = 'Bạn đã nhập sai mật khẩu!';
                return redirect()->back()->withErrors(['error' => $error])->with('loginError', $error);
            }
        } else {
            // Tài khoản không tồn tại
            $error = 'Tài khoản không tồn tại hoặc đã bị khóa!';
            return redirect()->back()->withErrors(['error' => $error])->with('loginError', $error);
        }
    }

    // SignUp
    public function signup()
    {
        $cate = Category::all();
        $auth = Author::all();
        $publishers = Publisher::all();
        return view('client/customer/signup', ['publishers' => $publishers,'auth' => $auth, 'cate' => $cate]);
    }
    public function signupPost(SignupRequest $request)
    {
        $data['name'] = $request->name;
        $data['username'] = $request->username;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $user = Customer::create($data);

        if (!$user) {
            return redirect(route('signup'));
        } else {
            return redirect(route('signin'))->with(['message' => 'Đăng kí tài khoản thành công !']);
        }
    }

    // Logout
    function logout()
    {
        FacadesSession::flush();
        Auth::logout();
        return redirect()->route('signin');
    }

    //My-account
    public function showDetail()
    {
        $cate = Category::all();
        $auth = Author::all();
        $user = Auth::user();
        $publishers = Publisher::all();
        return view('client.customer.my-Account.showDetail', ['publishers' => $publishers,'user' => $user, 'auth' => $auth, 'cate' => $cate]);
    }
    public function editDetail()
    {
        $cate = Category::all();
        $auth = Author::all();
        $user = Auth::user();
        $publishers = Publisher::all();
        return view('client.customer.my-Account.editDetail', ['publishers' => $publishers,'user' => $user, 'auth' => $auth, 'cate' => $cate]);
    }
    public function editDetailPost(MyAccountRequest $request)
    {
        $user = Auth::user();
        if ($request->isMethod('POST')) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            if ($user->save()) {
                return redirect()->route('my.account.detail')
                    ->with('success', 'User updated successfully');
            } else {
                return redirect()->back()
                    ->withInput();
            }
        }
    }
    public function showPass()
    {
        $cate = Category::all();
        $auth = Author::all();
        $publishers = Publisher::all();
        return view('client.customer.my-account.editPass', ['publishers' => $publishers,'auth' => $auth, 'cate' => $cate]);
    }

    public function changePass(ChangePassRequest $request)
    {
        $user = Auth::user();
        if (Hash::check($request->password, $user->password)) {
            if ($request->newpassword == $request->cfpassword) {
                $password = Hash::make($request->newpassword);
                User::find(Auth::id())->update(['password' => $password]);
                return redirect()->route('my.account.pass')
                    ->with('success', 'Đổi mật khẩu thành công');
            } else {
                $pass2 = 'Bạn phải nhập lại đúng mật khẩu mới!';
                return redirect()->back()->withInput()->withErrors(['error' => $pass2])->with('Errorpass2', $pass2);
            }
        } else {
            $pass1 = 'Bạn nhập sai Mật khẩu cũ!';
            return redirect()->back()->withInput()->withErrors(['error' => $pass1])->with('Errorpass1', $pass1);
        }
    }

    //Reset pass
    public function forgetPassword()
    {
        $cate = Category::all();
        $auth = Author::all();
        $publishers = Publisher::all();
        return view('client.customer.forgetPass', ['publishers' => $publishers,'auth' => $auth, 'cate' => $cate]);
    }
    public function forgetPasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users|unique:password_reset_tokens'
        ], [
            'email.required' => 'Bạn hãy nhập Email!',
            'email.email' => 'Bạn hãy nhập đúng định dạng Email!',
            'email.exists' => 'Email của bạn không tồn tại trên hệ thống!',
            'email.unique' => 'Đường dẫn đặt lại mật khẩu đã được gửi tới Email của bạn!',
        ]);
        $token = Str::random(64);
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
        ]);
        Mail::send('client/customer/resetPass', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        return redirect()->route('forget.password')->with('success', 'Bạn hãy truy cập vào đường dẫn trong Email để đặt lại Mật khẩu!');
    }

    public function resetPassword($token)
    {
        $cate = Category::all();
        $auth = Author::all();
        $publishers = Publisher::all();
        return view('client.customer.newPass', compact( 'publishers','token', 'cate', 'auth'));
    }
    public function resetPasswordPost(ResetPassRequest $request)
    {
        $updatePass = DB::table('password_reset_tokens')->where([
            'email' => $request->email,
            'token' => $request->token,
        ])->first();

        if ($updatePass) {
            if ($request->password == $request->password_confirm) {
                User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
                DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();
                return redirect()->route('signin')->with('success', 'Mật khẩu của bạn đã được đặt lại hãy đăng nhập thôi!');
            } else {
                return redirect()->back()->withErrors(['error' => 'Confirm Password phải trùng với New Password!'])->with('error', 'Confirm Password phải trùng với New Password!');
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Đang bị lỗi!'])->with('error', 'Đang bị lỗi!');
        }
    }
}