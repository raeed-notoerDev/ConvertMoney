<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function statistics()
    {
        return response()->json([
            'users' => DB::table('users')
                ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
                ->select('users.*')->where('users_roles.role_id', '<>', 1)->get()->count(),
            'agents' => DB::table('users')
                ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
                ->select('users.*')->where('users_roles.role_id', 1)->get()->count(),
            'users_admins' => DB::table('users')
                ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
                ->select('users.*')->where('users_roles.role_id', 2)->get()->count(),
            'users_sub_admins' => DB::table('users')
                ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
                ->select('users.*')->where('users_roles.role_id', '<>', 2)
                ->where('users_roles.role_id', '<>', 1)->get()->count(),
            'agents_approved' => DB::table('users')
                ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
                ->select('users.*')->where('users_roles.role_id', 1)
                ->where('users.status', 'active')->get()->count(),
            'agents_hold' => DB::table('users')
                ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
                ->select('users.*')->where('users_roles.role_id', 1)
                ->where('users.status', 'block')->get()->count(), 'agents_blocked' => DB::table('users')
                ->join('users_roles', 'users.id', '=', 'users_roles.user_id')
                ->select('users.*')->where('users_roles.role_id', 1)
                ->where('users.status', 'hold')->get()->count(),
            'transactions' =>Transaction::count(),
            'transactions_waiting' =>Transaction::where('status','waiting')->count(),
            'transactions_approved' =>Transaction::where('status','approved')->count(),
            'transactions_holds' =>Transaction::where('status','hold')->count(),
            'transactions_paid' =>Transaction::where('status','paid')->count(),
            'transactions_blocked' =>Transaction::where('status','blocked')->count(),
            'transactions_cancelled' =>Transaction::where('status','canceled')->count(),

        ]);
    }


    public function transactions()
    {

    }

    public function transaction_receiver()
    {

    }

    public function transaction_sender()
    {

    }

    public function amounts()
    {

    }

    public function profits()
    {

    }

    public function users_blocked()
    {

    }

    public function users_hold()
    {

    }

    public function users_activate()
    {

    }
}
