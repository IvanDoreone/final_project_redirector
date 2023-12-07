<?php
namespace App\Actions;

use App\Models\Donors;
use App\Models\NewsModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HandeMyResources {

    public function valid_write($request) {
        $valid  = $request->validate([
            'name' => 'required|min:2|max:100',
            'uri' => 'required|min:14|max:100',
            'theme' => 'required|min:4|max:200',
            'coast' => 'min:1|max:7|numeric|between:1,100000',

        ]);
        //dd($valid); выводит результаты после проверки (только поля из формы)
        $review = new Donors();
        $review->name = $request->input('name');
        $review->uri = $request->input('uri');
        $review->theme = $request->input('theme');
        $review->coast = $request->input('coast');
        $review->user_id = Auth::user()->id;
        $review->save(); // запись данных в таблицу Offers
        return $review->all();
    }

         function index() {
        $donors = DB::table('donors')
        ->select(DB::raw('*'))
        ->where('user_id', Auth::user()->id)
        ->get();

        $my_subscribes = DB::table('subscribes')
        ->select(DB::raw('offer_id, offers.status, donor_id, offers.site_uri, offers.site_name, offers.coast'))
        ->join('offers','subscribes.offer_id','=','offers.id')
        ->join('donors','donors.id','=','subscribes.donor_id')
        ->join('users','users.id','=','donors.user_id')
        ->where('users.id', Auth::user()->id)
        ->where('subscribes.status', '!=', 'deleted')
        ->get()->toArray();

        //dd($my_subscribes);

        $my_transitions = DB::table('transitions')
        ->join('subscribes','subscribes.id','=','transitions.subscribes_id')
        ->join('offers','offers.id','=','subscribes.offer_id')
        ->join('donors','donors.id','=','subscribes.donor_id')
        ->where('donors.user_id', Auth::user()->id)
        ->select(DB::raw('count(transitions.id) as count , donors.id'))
        ->groupBy('donors.id')
        ->get()->toArray();

        //dd($my_transitions[0]->count);



        //dd($my_subscribes);
        //return [$donors->all()];
        return ['resource' => $donors->all(), 'my_subscribes' => $my_subscribes, 'number' => 0, 'my_transitions' => $my_transitions];

        }

        public function show() {

        }


        public function edit_resource($request) {
            $valid  = $request->validate([
                'new_uri' => 'required|min:14|max:100',
                'new_theme' => 'required|min:4|max:200',
                'new_coast' => 'min:1|max:7|numeric|between:1,100000',
            ]);
            //dd($valid);
            $id = $request['resourse_id'];
            $uri = $request['new_uri'];
            $coast = $request['new_coast'];
            $theme = $request['new_theme'];

                DB::table('donors')->where('id',$id)->update(['uri' => $uri]);
                DB::table('donors')->where('id',$id)->update(['coast' => $coast]);
                DB::table('donors')->where('id',$id)->update(['theme' => $theme]);
            }


    public function resource_delete($request) {
        $id = ($request['resourse_id']);
        DB::table('donors')->where('id', '=', $id)->delete();
    }



}



