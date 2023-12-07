<?php
namespace App\Actions;
use App\Models\Donors;
use App\Models\Offers;
use App\Models\NewsModel;
use App\Models\Subscribes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\AssignOp\Concat;

class Hande {

    public function offer_subscribe($request) {
        $valid  = $request->validate([
            'offer_uri' => 'required',
            'offer_coast' => 'required',
            'select_offer' => 'required',
            'offer_uri_id' => 'required',
        ]);

        $subscribe = new Subscribes();
        $subscribe->offer_id = $request->input('offer_uri_id');
        $subscribe->donor_id = $request->input('select_offer');
        $subscribe->coast = $request->input('offer_coast');
        $subscribe->status = 'active';
        $subscribe->save(); // запись данных в таблицу

         $list = Donors::select('offer_reference')->where('id', $request->input('select_offer'))->get()->toArray();
         $current = $list[0]['offer_reference'];
         $current = $current.','.$request->input('offer_uri_id');
         DB::table('offers')->where('id', $request->input('offer_uri_id'))
         ->update([
            'subscribs_amount' => DB::raw('subscribs_amount + 1'),
         ]);
         DB::table('donors')->where('id', $request->input('select_offer'))
         ->update([
            'offer_reference' => $current,
            'subscribs_amount' => DB::raw('subscribs_amount + 1'),
         ]);

         

    }
    public function edit_link_text($request) {
        $valid  = $request->validate([
            'new_link_text' => 'required|min:2|max:100',
        ]);

        $id = $request['offer_id'];
        $new_text = $request->get('new_link_text');
        DB::table('offers')
                  ->where('id',$id)
                  ->update(['link_text' => $new_text]);

    }

    public function control_subscribes($request) {

if ($request->has('to_stopped')) {
    DB::table('subscribes')
    ->where('id',$request->input('to_stopped'))
    ->update(['status' => 'stopped']);
}
if ($request->has('to_active')) {
    DB::table('subscribes')
    ->where('id',$request->input('to_active'))
    ->update(['status' => 'active']);
}
    }

    public function control_subscribes_ajax($request) {
        //return response($request);
        if ($request->input('to_do') == 'to_stopped') {
            DB::table('subscribes')
            ->where('id',$request->input('id'))
            ->update(['status' => 'stopped']);
        
            $data = ['status' => 'stopped'];
            return response()->json($data);
            
        }
        if ($request->input('to_do') == 'to_active') {
            DB::table('subscribes')
            ->where('id',$request->input('id'))
            ->update(['status' => 'active']);
        
        
            $data = ['status' => 'active'];
            return response()->json($data);
        }
            }



    public function delete_subscribes($request) {

        if ($request->has('to_delete')) {
            $list = DB::table('donors')
            ->select('donors.offer_reference','subscribes.offer_id')
                ->join('subscribes','subscribes.donor_id','=','donors.id')
                ->where('subscribes.id', $request->input('to_delete'))
                ->where('subscribes.status', '!=', 'deleted')
                ->get()->toArray();
            if(isset($list[0])) {
                $current_list = $list[0]->offer_reference;
                $current_offer = $list[0]->offer_id;
                $arr = explode(",", $current_list);
                if (($key = array_search($current_offer, $arr)) !== false) {
                    unset($arr[$key]);
                }
                $arr_new = implode(",", $arr);

            DB::table('donors')
            ->where('id', DB::table('subscribes')
            ->select('donor_id')
            ->where('id', $request->input('to_delete')))
            ->update([
                'subscribs_amount' => DB::raw('subscribs_amount - 1'),
                'offer_reference' => $arr_new,
            ]);
        }

            DB::table('offers')
            ->select('subscribs_amount')
            ->where('id', DB::table('subscribes')
            ->select('offer_id')
            ->where('id',$request->input('to_delete')))
            ->update([
                'subscribs_amount' => DB::raw('subscribs_amount - 1'),
            ]);

            DB::table('subscribes')
            ->where('id',$request->input('to_delete'))
            ->update([
                'status' => 'deleted',
            ]);
        }
        }

    public function valid_write($request) {
        $valid  = $request->validate([
            'site_name' => 'required|min:2|max:100',
            'site_uri' => 'required|min:14|max:100|active_url',
            'site_theme' => 'required|min:4|max:50',
            'link_text' => 'required|min:2|max:100',
            'coast' => 'min:1|max:7|numeric|between:1,1000000',

        ]);
        //dd($valid); выводит результаты после проверки (только поля из формы)
        $review = new Offers();
        $review->site_name = $request->input('site_name');
        $review->site_uri = $request->input('site_uri');
        $review->site_theme = $request->input('site_theme');
        $review->link_text = $request->input('link_text');
        $review->coast = $request->input('coast');
        $review->user_id = Auth::user()->id;
        $review->save(); // запись данных в таблицу Offers
        return $review->all();
    }

    public function crud_test_store($request) {
        $valid  = $request->validate([
            'name' => 'required|min:4|max:20',
            'title' => 'required|min:5|max:50',
            'thenew' => 'required|min:5|max:500'
        ]);
        $new = new NewsModel();
        $new->name = $request->input('name');
        $new->title = $request->input('title');
        $new->thenew = $request->input('thenew');
        $new->save(); // запись данных в таблицу contact_models
        return $new->all();
    }



    public function index() {
        $offers = DB::table('offers')
        ->where('user_id', Auth::user()->id)
        ->orderBy('created_at','desc')
        ->get();

        $subscribes = DB::table('offers')
        ->select(DB::raw('offer_id, donors.name, donors.uri, offers.coast, subscribes.status, offers.id as id'))
        ->join('subscribes','offers.id','=','subscribes.offer_id' )
        ->join('donors','donors.id','=','subscribes.donor_id')
        ->where('offers.user_id', '=', Auth::user()->id)
        ->where('subscribes.status', '!=', 'deleted')
        ->get()->toArray();

        $transitions = DB::table('transitions')
        ->select(DB::raw('offer_id as id, count(transitions.id) as count, sum(subscribes.coast) as summ , sum(subscribes.coast) as count, count(transitions.id) as count_transitions'))
        ->join('subscribes','subscribes.id','=','transitions.subscribes_id' )
        ->join('offers','offers.id','=','subscribes.offer_id')
        ->where('offers.user_id', '=', Auth::user()->id)
        ->groupBy('offer_id')
        ->get()->toArray();

        $transitionsday = DB::table('transitions')
        ->join('subscribes','subscribes.id','=','transitions.subscribes_id' )
        ->join('offers','offers.id','=','subscribes.offer_id')
        ->where('offers.user_id', '=', Auth::user()->id)
        ->whereDate('transitions.created_at', '=', date('Y-m-d'))
        ->select(DB::raw('offer_id as id, sum(subscribes.coast) as count, count(transitions.id) as count_transitions'))
        ->groupBy('offer_id')
        ->get()->toArray();

        $transitionsmonth = DB::table('transitions')
        ->select(DB::raw('offer_id as id, sum(subscribes.coast) as count, count(transitions.id) as count_transitions'))
        ->join('subscribes','subscribes.id','=','transitions.subscribes_id' )
        ->join('offers','offers.id','=','subscribes.offer_id')
        ->where('offers.user_id', '=', Auth::user()->id)
        ->whereMonth('transitions.created_at', '=', date('m'))
        ->groupBy('offer_id')
        ->get()->toArray();

        $transitionsyear = DB::table('transitions')
        ->select(DB::raw('offer_id as id, sum(subscribes.coast) as count, count(transitions.id) as count_transitions'))
        ->join('subscribes','subscribes.id','=','transitions.subscribes_id' )
        ->join('offers','offers.id','=','subscribes.offer_id')
        ->where('offers.user_id', '=', Auth::user()->id)
        ->whereYear('transitions.created_at', '=', date('Y'))
        ->groupBy('offer_id')
        ->get()->toArray();

        $transitionsall = DB::table('transitions')
        ->select(DB::raw('offer_id as id, sum(subscribes.coast) as count, count(transitions.id) as count_transitions'))
        ->join('subscribes','subscribes.id','=','transitions.subscribes_id' )
        ->join('offers','offers.id','=','subscribes.offer_id')
        ->where('offers.user_id', '=', Auth::user()->id)
        ->groupBy('offer_id')
        ->get()->toArray();

        $expenseday = 0;
        $expensemonth = 0;
        $expenseyear = 0;
        $expense = 0;

        $transitions_day = 0;
        $transitions_month = 0;
        $transitions_year = 0;
        $transition_all = 0;

//dd($transitionsmonth);
        foreach ($transitionsday as  $value) {
            $expenseday += $value->count_transitions;
        }
        foreach ($transitionsmonth as  $value) {
            $expensemonth += $value->count_transitions;
        }
        foreach ($transitionsyear as  $value) {
            $expenseyear += $value->count_transitions;
        }
        foreach ($transitions as  $value) {
            $expense += $value->count_transitions;
        }

        foreach ($transitionsday as  $value) {
            $transitions_day += $value->count;
        }
        foreach ($transitionsmonth as  $value) {
            $transitions_month += $value->count;
        }
        foreach ($transitionsyear as  $value) {
            $transitions_year += $value->count;
        }
        foreach ($transitions as  $value) {
            $transition_all += $value->count;
        }
        //dd($transitionsday);


        return ['offers' => $offers,
        'subscribes' => $subscribes,
        'number' =>0, 'transitions' => $transitions,
        'transitionsday' => $transitionsday,
        'transitionsmonth' => $transitionsmonth,
        'transitionsyear' => $transitionsyear,
        'transitionsall' => $transitionsall,

        'transition_all' => $transition_all,
        'transitions_day' => $transitions_day,
        'transitions_month' => $transitions_month,
        'transitions_year' => $transitions_year,

        'expensemonth' => $expensemonth,
        'expenseyear' => $expenseyear,
        'expense' => $expense,
        'expenseday' => $expenseday,




    ];
        }
    public function show($name) {
        return NewsModel::where('id', '=', $name)->get();
        }
    public function edit($request) {

        //dd($request['thenew']);
        $id = $request['news_id'];
        $new = $request['thenew'];
        DB::table('news_models')
              ->where('id',$id)
              ->update(['thenew' => $new]);
        }

    public function offer_edit($request) {
        $id = $request['offers_id'];
        $status = $request['status'];
        if ($status == 'active') {
        DB::table('offers')
                  ->where('id',$id)
                  ->update(['status' => 'stopped']);
        } else  {
        DB::table('offers')
                  ->where('id',$id)
                  ->update(['status' => 'active']);
        }
        }

    public function crud_test_delete($request) {
        $id = ($request['news_id']);
        NewsModel::where('id', '=', $id)->delete();
        return view('news');
    }

    public function offer_delete($request) {
        $id = ($request['offer_id']);
        Offers::where('id', '=', $id)->delete();
    }
    public function all_offers() {

        $id = Auth::user()->id;
        $donors = Donors::where('user_id', $id)->get();
        $offers = Offers::all();

        $subscribescount = DB::table('subscribes')
        ->select(DB::raw('offer_id'))
        ->join('donors','donors.id','=','subscribes.donor_id' )
        ->where('donors.user_id', '=', $id)
        ->where('subscribes.status', '!=', 'deleted')
        ->get()->pluck('offer_id')->toArray();

        $count_subscribes = DB::table('subscribes')
        ->select(DB::raw('offer_id, count(donor_id) as count'))
        ->join('donors','donors.id','=', 'subscribes.donor_id')
        ->join('users','users.id','=', 'donors.user_id')
        ->where('subscribes.status', '!=', 'deleted')
        ->where('donors.user_id', '=', $id)
        ->groupBy('offer_id')->get()->pluck('count' , 'offer_id')->toArray();

        return ['offers' => $offers -> all(), 'donors' => $donors -> all(), 'subscribers_my' => $subscribescount, 'donors_list_subscribes_by_offer_id' => $count_subscribes];
    }

}



