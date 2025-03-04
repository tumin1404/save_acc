<?php

namespace App\Http\Controllers;
use App\Models\Account;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Crypt;
use PhpParser\Node\Stmt\TryCatch;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Account::all(); // Lấy tất cả dữ liệu từ bảng account
        // foreach ($accounts as $account) {
        //     $account->plain_password = Crypt::decryptString($account->password);
        // }

        return view('admin.pages.account', compact('accounts')); // Truyền dữ liệu đến view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required', // username là bắt buộc
                'password' => 'required|min:5', // password bắt buộc và tối thiểu 6 ký tự
                'account_name' => 'required',
                'website_app' => '',
                'app_phone_authen' => '',
                'phone_email_verify' => '',
                '2FA' => '',
            ]);
            // Kiểm tra trùng lặp
            $existingAccount = DB::table('account')
            ->where('username', $request->input('username'))
            ->where('password', $request->input('password'))
            ->where('account_name', $request->input('account_name'))
            ->where('website_app', $request->input('website_app'))
            ->first();

            if ($existingAccount) {
                return redirect()->back()->with('error', 'Lỗi: Tài khoản đã tồn tại (trùng username, password, account_name và website_app).');
            }
    
            $account = new Account();
            $account->username = $request->input('username');
            $account->password = $request->input('password');
            $account->account_name = $request->input('account_name');
            $account->website_app = $request->input('website_app');
            $account->phone_email_verify = $request->input('phone_email_verify');
            $account->app_phone_authen = $request->input('app_phone_authen');
            $account->{'2FA'} = $request->input('2FA');
    
            // Hash password trước khi lưu
            // $account->password = Hash::make($request->input('password'));
    
            $account->save();
            // return redirect()->back()->with('success', 'Tài khoản đã được thêm thành công!');
            return response()->json(['success' => true, 'message' => 'Tài khoản đã được thêm thành công!']);
        } catch (QueryException $e) {
            // Bắt lỗi từ database (ví dụ: trùng username, lỗi kết nối, ...)
            $errorCode = $e->getCode();
            if ($errorCode == 23000) { // Lỗi trùng lặp dữ liệu (ví dụ: username)
                // return redirect()->back()->with('error', 'Lỗi: Tên đăng nhập đã tồn tại.');
                return response()->json(['success' => false, 'message' => 'Lỗi: Tên đăng nhập đã tồn tại.' . $e->getMessage()], 500);
            } else {
                return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()], 500);
            }
    
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }

    public function getAccountsData()
    {
        $account = Account::all();
        return response()->json($account);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Tìm danh mục theo ID
        $account = Account::find($id);

        // Kiểm tra xem danh mục có tồn tại hay không
        if (!$account) {
            return response()->json(['message' => 'Danh mục không tồn tại'], 404);
        }

        // Trả về dữ liệu danh mục dưới dạng JSON
        return response()->json($account);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $account = Account::findOrFail($id);
            $account->delete();
    
            return redirect()->back()->with('success', 'Tài khoản đã được xoá thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: Không thể xoá tài khoản!');
        }

    }
}
