<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // Admin(Change Password) -> view

    public function changePassword()
    {
        return view('admin.account.changePassword');
    }

    // Admin (Change Password)->get data

    public function passwordChange(Request $request)
    {
        // dd($request->all());
        $this->passwordValidatationCheck($request);
        $currentId = Auth::user()->id;
        $user = User::select('password')->where('id', $currentId)->first();
        // dd($user);
        $dbhashvalue = $user->password; // to get hash password

        // dd($dbhashvalue);

        if (Hash::check($request->oldPassword, $dbhashvalue)) {

            $data = [
                'password' => Hash::make($request->newPassword)
            ];
            User::where('id', $currentId)->update($data);

            // Auth::logout();
            return back()->with(['changePassword' => 'Password Changed']);
        }

        return back()->with(['incorrectPassword' => "Old Password does not match"]);
        // dd($user->toArray());
    }

    // Admin (Account List)

    public function list()
    {
        $adminLists = User::when(request('searchKey'), function ($query) {
            $query->orWhere('name', 'like', '%' . request('searchKey') . '%')
                ->orWhere('email', 'like', '%' . request('searchKey') . '%')
                ->orWhere('gender', 'like', '%' . request('searchKey') . '%')
                ->orWhere('phone', 'like', '%' . request('searchKey') . '%')
                ->orWhere('address', 'like', '%' . request('searchKey') . '%');
        })
            ->where('role', 'admin')->paginate(5);

        $adminLists->appends(request()->all());
        // dd($adminLists->toArray());
        return view('admin.account.list', compact('adminLists'));
    }

    // Admin (Account Infos)
    public function infos()
    {
        return view('admin.account.infos');
    }

    // Admin (Account Edit)
    public function edit()
    {
        return view('admin.account.edit');
    }

    // Admin (Account Update)
    public function update($id, Request $request)
    {
        // dd($id, $request->all());
        $this->accountValidationCheck($request, $id);
        $data = $this->getUserData($request);

        // for image
        if ($request->hasFile('image')) {
            $dbImage = User::where('id', $id)->first();
            $dbImage = $dbImage->image;
            // dd($dbImage);

            if ($dbImage !== null) {
                Storage::delete('public/' . $dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        }

        User::where('id', $id)->update($data);
        return redirect()->route('account#infos')->with(['updateSuccess' => 'Updated Success']);
    }

    // Admin (Role Edit)
    public function editRole($id)
    {
        $account = User::findOrFail($id);
        return view('admin.account.changeRole', compact('account'));
    }

    // Admin (role Update)
    public function updateRole($id, Request $request)
    {
        User::where('id', $id)->update([
            'role' => $request->role
        ]);
        return redirect(route('admin#list'))->with('success', 'Role Updated Successfully.');
    }

    //  Admin (role Update) with Ajax
    public function roleUpdatewithAjax(Request $request)
    {
        $user = User::findOrFail($request->roleId);
        $user->role = $request->status;
        $user->save();

        return response()->json([
            'message' => "Role Updated Successfully.",
        ], 200);
    }

    // Admin (Account Delete)
    public function delete($id)
    {
        User::where('id', $id)->delete();

        return back()->with('deleteMessage', 'Account Deleted!');
    }

    // To get user Data For Update
    private function getUserData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'updated_at' => Carbon::now()

        ];
    }

    // Admin (account Validatation Check)
    private function accountValidationCheck($request, $id)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'image' => 'mimes:png,jpg,jpeg|file',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required'
        ])->validate();
    }

    // Admin (password Validatation Check)

    private function passwordValidatationCheck($request)
    {
        Validator::make($request->all(), [
            'oldPassword' => 'required|min:8|max:15',
            'newPassword' => 'required|min:8|max:15',
            'confirmPassword' => 'required|min:8|max:15|same:newPassword',
        ])->validate();
    }
}
