<?php
namespace App\Actions;
use App\Models\Donors;
use App\Models\Offers;
use App\Models\NewsModel;
use App\Models\Subscribes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\AssignOp\Concat;

class HandeAnalitics {

    public function my_subscribes() {

        $my_subscribes = DB::table('offers')
        ->select(DB::raw('offers.site_name, offers.id as offer_id, donors.id as donor_id, offers.site_uri,
        offers.coast as offer_coast, subscribes.created_at, subscribes.donor_id, subscribes.status, subscribes.coast as coast,
        subscribes.id as id, offers.link_text as text , donors.uri as donor_uri, donors.name as donor_name' ))
        ->join('subscribes','subscribes.offer_id','=','offers.id')
        ->join('donors','donors.id','=','subscribes.donor_id')
        ->join('users','users.id','=','donors.user_id')
        ->where('users.id', Auth::user()->id)
        ->where('subscribes.status', '!=', 'deleted')
        ->get();

        $my_transitions = DB::table('transitions')
        ->join('subscribes','subscribes.id','=','transitions.subscribes_id')
        ->join('donors','donors.id','=','subscribes.donor_id')
        ->where('donors.user_id', Auth::user()->id)
        ->select(DB::raw('count(transitions.id) as count , subscribes.id, sum(subscribes.coast) as expense'))
        ->groupBy('subscribes.id')
        ->get()->toArray();

        $my_transitionsday = DB::table('transitions')
        ->join('subscribes','subscribes.id','=','transitions.subscribes_id')
        ->join('donors','donors.id','=','subscribes.donor_id')
        ->where('donors.user_id', Auth::user()->id)
        ->whereDate('transitions.created_at', '=', date('Y-m-d'))
        ->select(DB::raw('count(transitions.id) as count , subscribes.id, sum(subscribes.coast) as expense'))
        ->groupBy('subscribes.id')
        ->get()->toArray();

        $my_transitionsmonth = DB::table('transitions')
        ->join('subscribes','subscribes.id','=','transitions.subscribes_id')
        ->join('donors','donors.id','=','subscribes.donor_id')
        ->where('donors.user_id', Auth::user()->id)
        ->whereMonth('transitions.created_at', date('m'))
        ->select(DB::raw('count(transitions.id) as count , subscribes.id, sum(subscribes.coast) as expense'))
        ->groupBy('subscribes.id')
        ->get()->toArray();

        $my_transitionsyear = DB::table('transitions')
        ->join('subscribes','subscribes.id','=','transitions.subscribes_id')
        ->join('donors','donors.id','=','subscribes.donor_id')
        ->where('donors.user_id', Auth::user()->id)
        ->whereYear('transitions.created_at', '=', date('Y'))
        ->select(DB::raw('count(transitions.id) as count , subscribes.id, sum(subscribes.coast) as expense'))
        ->groupBy('subscribes.id')
        ->get()->toArray();

        $expenseday = 0;
        $expensemonth = 0;
        $expenseyear = 0;
        $expense = 0;

        $transitionsday = 0;
        $transitionsmonth = 0;
        $transitionsyear = 0;
        $transition = 0;


        foreach ($my_transitionsday as  $value) {
            $expenseday += $value->expense;
        }
        foreach ($my_transitionsmonth as  $value) {
            $expensemonth += $value->expense;
        }
        foreach ($my_transitionsyear as  $value) {
            $expenseyear += $value->expense;
        }
        foreach ($my_transitions as  $value) {
            $expense += $value->expense;
        }

        foreach ($my_transitionsday as  $value) {
            $transitionsday += $value->count;
        }
        foreach ($my_transitionsmonth as  $value) {
            $transitionsmonth += $value->count;
        }
        foreach ($my_transitionsyear as  $value) {
            $transitionsyear += $value->count;
        }
        foreach ($my_transitions as  $value) {
            $transition += $value->count;
        }

//dd($transitionyear);
    return([
        'my_subscripts'=> $my_subscribes,
        'my_transitions'=> $my_transitions,
        'my_transitionsday'=> $my_transitionsday,
        'my_transitionsmonth'=> $my_transitionsmonth,
        'my_transitionsyear'=> $my_transitionsyear,
        'expenseday'=> $expenseday,
        'expensemonth'=> $expensemonth,
        'expenseyear'=> $expenseyear,
        'transitionsday'=> $transitionsday,
        'transitionsmonth'=> $transitionsmonth,
        'transitionsyear'=> $transitionsyear,
        'transition'=> $transition,
        'expense'=> $expense,

    ]);
    }

    public function analitics_admin() {
        $subscribes = DB::table('subscribes')
        ->select(DB::raw('subscribes.id, subscribes.created_at, count(transitions.id) as transitions_count,
        count(declanes.id) as declanes_count, donors.uri as donor_uri, subscribes.donor_id as donor_id,
        offers.site_uri as offer_uri, subscribes.offer_id as offer_id, subscribes.coast as coast,
        donors.user_id as donor_user_id, offers.user_id as offer_user_id, subscribes.status,
        donors.name as donor_site_name, offers.site_name as offer_site_name'))
        ->leftJoin('transitions','transitions.subscribes_id','=','subscribes.id')
        ->leftJoin('declanes','declanes.subscribes_id','=','subscribes.id')
        ->leftJoin('donors','donors.id','=','subscribes.donor_id')
        ->leftJoin('offers','offers.id','=','subscribes.offer_id')
        ->groupBy('subscribes.id','subscribes.created_at', 'donors.uri', 'subscribes.donor_id', 'offers.site_uri',
        'subscribes.offer_id', 'subscribes.coast' ,'donors.user_id' , 'offers.user_id' , 'subscribes.status',
        'donors.name','offers.site_name')
        ->orderBy('status','asc')
        ->orderBy('subscribes.created_at','desc');

        $subscribes_day = DB::table('subscribes')
        ->select(DB::raw('subscribes.id, subscribes.created_at, count(transitions.id) as transitions_count,
        count(declanes.id) as declanes_count, donors.uri as donor_uri, subscribes.donor_id as donor_id,
        offers.site_uri as offer_uri, subscribes.offer_id as offer_id, subscribes.coast as coast,
        donors.user_id as donor_user_id, offers.user_id as offer_user_id, subscribes.status,
        donors.name as donor_site_name, offers.site_name as offer_site_name'))
        ->leftJoin('transitions','transitions.subscribes_id','=','subscribes.id')
        ->leftJoin('declanes','declanes.subscribes_id','=','subscribes.id')
        ->leftJoin('donors','donors.id','=','subscribes.donor_id')
        ->leftJoin('offers','offers.id','=','subscribes.offer_id')
        ->groupBy('subscribes.id','subscribes.created_at', 'donors.uri', 'subscribes.donor_id', 'offers.site_uri',
        'subscribes.offer_id', 'subscribes.coast' ,'donors.user_id' , 'offers.user_id' , 'subscribes.status',
        'donors.name','offers.site_name')
        ->orderBy('status','asc')
        ->orderBy('subscribes.created_at','desc')
        ->whereDate('transitions.created_at', '=', date('Y-m-d'))
        ->orWhereDate('declanes.created_at', '=', date('Y-m-d'))
        ->get()->toArray();

        $subscribes_month = DB::table('subscribes')
        ->select(DB::raw('subscribes.id, subscribes.created_at, count(transitions.id) as transitions_count,
        count(declanes.id) as declanes_count, donors.uri as donor_uri, subscribes.donor_id as donor_id,
        offers.site_uri as offer_uri, subscribes.offer_id as offer_id, subscribes.coast as coast,
        donors.user_id as donor_user_id, offers.user_id as offer_user_id, subscribes.status,
        donors.name as donor_site_name, offers.site_name as offer_site_name'))
        ->leftJoin('transitions','transitions.subscribes_id','=','subscribes.id')
        ->leftJoin('declanes','declanes.subscribes_id','=','subscribes.id')
        ->leftJoin('donors','donors.id','=','subscribes.donor_id')
        ->leftJoin('offers','offers.id','=','subscribes.offer_id')
        ->groupBy('subscribes.id','subscribes.created_at', 'donors.uri', 'subscribes.donor_id', 'offers.site_uri',
        'subscribes.offer_id', 'subscribes.coast' ,'donors.user_id' , 'offers.user_id' , 'subscribes.status',
        'donors.name','offers.site_name')
        ->orderBy('status','asc')
        ->orderBy('subscribes.created_at','desc')
        ->whereMonth('transitions.created_at', date('m'))
        ->orWhereMonth('declanes.created_at', '=', date('m'))
        ->get()->toArray();

        $subscribes_year = DB::table('subscribes')
        ->select(DB::raw('subscribes.id, subscribes.created_at, count(transitions.id) as transitions_count,
        count(declanes.id) as declanes_count, donors.uri as donor_uri, subscribes.donor_id as donor_id,
        offers.site_uri as offer_uri, subscribes.offer_id as offer_id, subscribes.coast as coast,
        donors.user_id as donor_user_id, offers.user_id as offer_user_id, subscribes.status,
        donors.name as donor_site_name, offers.site_name as offer_site_name'))
        ->leftJoin('transitions','transitions.subscribes_id','=','subscribes.id')
        ->leftJoin('declanes','declanes.subscribes_id','=','subscribes.id')
        ->leftJoin('donors','donors.id','=','subscribes.donor_id')
        ->leftJoin('offers','offers.id','=','subscribes.offer_id')
        ->groupBy('subscribes.id','subscribes.created_at', 'donors.uri', 'subscribes.donor_id', 'offers.site_uri',
        'subscribes.offer_id', 'subscribes.coast' ,'donors.user_id' , 'offers.user_id' , 'subscribes.status',
        'donors.name','offers.site_name')
        ->orderBy('status','asc')
        ->orderBy('subscribes.created_at','desc')
        ->whereYear('transitions.created_at', '=', date('Y'))
        ->orWhereYear('declanes.created_at', '=', date('Y'))
        ->get()->toArray();

        $transition_amount_all = 0;
        $transition_amount_day = 0;
        $transition_amount_month = 0;
        $transition_amount_year = 0;

        $declines_amount_all = 0;
        $declines_amount_day = 0;
        $declines_amount_month = 0;
        $declines_amount_year = 0;

        $profit_all = 0;
        $profit_day = 0;
        $profit_month = 0;
        $profit_year = 0;

        foreach ($subscribes->get()->toArray() as  $value) {
            $profit_all += $value->transitions_count * $value->coast *2/10;
        }
        foreach ($subscribes_day as  $value) {
            $profit_day += $value->transitions_count * $value->coast *2/10;
        }
        foreach ($subscribes_month as  $value) {
            $profit_month += $value->transitions_count * $value->coast *2/10;
        }
        foreach ($subscribes_year as  $value) {
            $profit_year += $value->transitions_count * $value->coast *2/10;
        }


        foreach ($subscribes->get()->toArray() as  $value) {
            $transition_amount_all += $value->transitions_count;
        }
        foreach ($subscribes_day as  $value) {
            $transition_amount_day += $value->transitions_count;
        }
        foreach ($subscribes_month as  $value) {
            $transition_amount_month += $value->transitions_count;
        }
        foreach ($subscribes_year as  $value) {
            $transition_amount_year += $value->transitions_count;
        }


        foreach ($subscribes->get()->toArray() as  $value) {
            $declines_amount_all += $value->declanes_count;
        }
        foreach ($subscribes_day as  $value) {
            $declines_amount_day += $value->declanes_count;
        }
        foreach ($subscribes_month as  $value) {
            $declines_amount_month += $value->declanes_count;
        }
        foreach ($subscribes_year as  $value) {
            $declines_amount_year += $value->declanes_count;
        }

        $declines_list =DB::table('declanes')
        ->select(DB::raw('subscribes_id, count(id) as count, donor_id'))
        ->groupBy('subscribes_id', 'donor_id')
        ->get()->toArray();

        //dd($declines_list);
        return ([
            'subscribes' => $subscribes->get()->toArray(),
            'subscribes_day' => $subscribes_day,
            'subscribes_month' => $subscribes_month,
            'subscribes_year' => $subscribes_year,
            'transition_amount_all' => $transition_amount_all,
            'transition_amount_day' => $transition_amount_day,
            'transition_amount_month' => $transition_amount_month,
            'transition_amount_year' => $transition_amount_year,
            'declines_amount_all' => $declines_amount_all,
            'declines_amount_day' => $declines_amount_day,
            'declines_amount_month' => $declines_amount_month,
            'declines_amount_year' => $declines_amount_year,
            'profit_all' => $profit_all,
            'profit_day' => $profit_day,
            'profit_month' => $profit_month,
            'profit_year' => $profit_year,
            'declines_list' => $declines_list,
            ] );
    }
}



