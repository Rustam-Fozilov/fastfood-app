<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function usersWithPagination(Request $request) {
        $users = DB::table('users')->where('is_admin', 0)->paginate(20);

        if($request->is_admin) {
            return response([
                'status' => 'success',
                'message' => 'Barcha foydalanuvchilar',
                'users' => $users
            ], Response::HTTP_OK);
        } else {
            return response([
                'status' => 'error',
                'message' => 'Siz ro`yxatdan o`tgan emassiz',
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function search(Request $request) {
        $users = DB::table('users')
            ->where('is_admin', 0)
            ->where('name', 'like', '%' . $request->search . '%')->where('is_admin', 0)
            ->orWhere('email', 'like', '%' . $request->search . '%')->where('is_admin', 0)
            ->orWhere('id', 'like', '%' . $request->search . '%')->where('is_admin', 0)
            ->get();

        return response([
            'status' => 'success',
            'message' => 'Foydalanuvchilar',
            'users' => $users
        ], Response::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')->where('is_admin', 0)->get();
        return response([
            'status' => 'success',
            'message' => 'Barcha foydalanuvchilar',
            'users' => $users
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_admin' => 0
        ]);

        return response([
            'status' => 'success',
            'message' => 'Foydalanuvchi muvaffaqiyatli yaratildi',
            'user' => $user
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response([
            'status' => 'success',
            'message' => 'Foydalanuvchi ma`lumotlari yangilandi',
            'user' => $user
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = DB::table('orders')->where('user_id', $id)->pluck('order_id');

        foreach ($order as $item) {
            OrderDetails::where('id', $item)->delete();
        }

        Order::where('user_id', $id)->delete();

        $user = User::find($id)->delete();

        return response([
            'status' => 'success',
            'message' => 'Foydalanuvchi muvaffaqiyatli o`chirildi',
            'user' => $user
        ], Response::HTTP_OK);
    }
}
