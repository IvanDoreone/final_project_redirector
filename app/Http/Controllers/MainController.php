<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\ContactModel;
use App\Models\Offers;
use App\Models\Donors;
use App\Models\Users;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Actions\Hande;
use App\Actions\Hande2;
use App\Actions\HandeAnalitics;
use App\Models\Subscribes;
use Illuminate\Support\Facades\DB;
use App\Providers\CustomServicePrivider;
use Illuminate\Support\Facades\Auth;
use app\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class MainController extends Controller
{    public function login() {

    }
    public function tests() {
        return view("tests");

    }
    public function redirector(Request $request, Hande2 $action) {
        return Redirect::to($action->redirect($request));
    }
    public function my_subscribes(HandeAnalitics $action) {
        App::setLocale('ru');
        return view('my_subscribes', $action->my_subscribes());
    }
    public function control_subscribes(Request $request, Hande $action) {
        $action->control_subscribes($request);
        return redirect('my_subscribes');
    }
    public function control_subscribes_ajax(Request $request, Hande $action) {
        //return response($request);
        if ($request->input('todo') == 'to_stopped') {
            DB::table('subscribes')
            ->where('id',$request->input('id'))
            ->update(['status' => 'stopped']);

            $data = ['status' => 'stopped'];
            return response()->json($data);

        }
        if ($request->input('todo') == 'to_active') {
            DB::table('subscribes')
            ->where('id',$request->input('id'))
            ->update(['status' => 'active']);


            $data = ['status' => 'active'];
            return response()->json($data);
        }
        //$action->control_subscribes_ajax($request);
        //return redirect('my_subscribes');
    }
    public function delete_subscribes(Request $request, Hande $action) {

        $action->delete_subscribes($request);
        return redirect('my_subscribes');
    }
    public function my_subscribes_delete_ajax(Request $request) {
     //return response($request->input('id'));

        if ($request->input('todo') == 'to_delete') {
            $list = DB::table('donors')
            ->select('donors.offer_reference','subscribes.offer_id')
                ->join('subscribes','subscribes.donor_id','=','donors.id')
                ->where('subscribes.id', $request->input('id'))
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
            ->where('id', $request->input('id')))
            ->update([
                'subscribs_amount' => DB::raw('subscribs_amount - 1'),
                'offer_reference' => $arr_new,
            ]);
        }

            DB::table('offers')
            ->select('subscribs_amount')
            ->where('id', DB::table('subscribes')
            ->select('offer_id')
            ->where('id',$request->input('id')))
            ->update([
                'subscribs_amount' => DB::raw('subscribs_amount - 1'),
            ]);

            DB::table('subscribes')
            ->where('id',$request->input('id'))
            ->update([
                'status' => 'deleted',
            ]);

            return response($request->input('id'));
        }
    }
    public function all_offers(Hande $action) {
        App::setLocale('ru');
        return view('all_offers', $action->all_offers());

    }
    public function my_resources(Hande2 $action) {
        App::setLocale('ru');
        return view('my_resources');
    }
    public function reviewers() {
        $offers = new Offers();
        return view('reviewers', ['reviewers' => $offers -> all()]);
    }
    public function analitics_client(Hande $action) {
        return view('analitics_client', $action->index());
    }
    public function analitics_webmaster(HandeAnalitics $action) {
        return view('analitics_webmaster', $action->my_subscribes());
    }
    public function analitics_admin(HandeAnalitics $action) {
            return view('analitics_admin', $action->analitics_admin());

    }
    public function offers_admin() {
        $offers = DB::table('offers')
        ->get()->toArray();
        return view('offers_admin', ['offers' => $offers] );
    }
    public function offers_control(Request $request) {
        if(($request->input('block'))) {
            DB::table('offers')
                    ->where('id',$request->input('block'))
                    ->update([
                        'status' => 'blocked',
                    ]);
        }
        if(($request->input('unblock'))) {
            DB::table('offers')
                    ->where('id',$request->input('unblock'))
                    ->update([
                        'status' => 'active',
                    ]);
        }
                return redirect('offers_admin');

    }

    public function offers_control_ajax(Request $request) {

                if(($request->input('todo')) == 'block') {
                    DB::table('offers')
                    ->where('id', $request->input('id'))
                    ->update([
                        'status' => 'blocked',
                    ]);

                            $data = ['id' => $request->input('id'), 'status' => 'blocked'];
                            return response($data);
                }
                if(($request->input('todo')) == 'unblock') {
                    DB::table('offers')
                    ->where('id', $request->input('id'))
                    ->update([
                        'status' => 'active',
                    ]);
                            $data = ['id' => $request->input('id'), 'status' => 'active'];
                            return response($data);
                }

    }


    public function resources_admin() {
        $resuorces = DB::table('donors')
        ->get()->toArray();

        return view('resources_admin', ['resuorces' => $resuorces] );
    }

    public function resources_control(Request $request) {
        //dd($request);
        if(($request->input('resource_to_stop'))) {
            DB::table('donors')
                    ->where('id', $request->input('resource_to_stop'))
                    ->update([
                        'status' => 'not_approved',
                    ]);
        }
        if(($request->input('resource_to_start'))) {
            DB::table('donors')
                    ->where('id', $request->input('resource_to_start'))
                    ->update([
                        'status' => 'approved',
                    ]);
        }
        return redirect('resources_admin');
    }

    public function resources_control_ajax(Request $request) {

    if(($request->input('todo')) == 'resource_to_stop') {
        DB::table('donors')
                    ->where('id', $request->input('id'))
                    ->update([
                        'status' => 'not_approved',
                    ]);

                $data = ['id' => $request->input('id'), 'status' => 'not_approved'];
                return response($data);
    }
    if(($request->input('todo')) == 'resource_to_start') {
        DB::table('donors')
                    ->where('id', $request->input('id'))
                    ->update([
                        'status' => 'approved',
                    ]);
                $data = ['id' => $request->input('id'), 'status' => 'approved'];
                return response($data);
    }
    }

    public function users_admin() {
        $users = DB::table('users')
        ->where('role','!=', 'admin')
        ->orderBy('created_at','desc')
        ->get()->toArray();

        return view('users_admin', ['users' => $users, 'status' => 'authorized'] );
    }

    public function users_admin_control(Request $request) {

if(($request->input('user_stop_authorize'))) {
    DB::table('users')
            ->where('id',$request->input('user_stop_authorize'))
            ->update([
                'status' => 'not_authorized',
            ]);
}
if(($request->input('user_start_authorize'))) {
    DB::table('users')
            ->where('id',$request->input('user_start_authorize'))
            ->update([
                'status' => 'authorized',
            ]);
}

        return redirect('users_admin');
    }

    public function users_admin_control_ajax(Request $request) {

    if(($request->input('todo')) == 'user_stop_authorize') {
        DB::table('users')
                ->where('id',$request->input('id'))
                ->update([
                    'status' => 'not_authorized',
                ]);

                $data = ['id' => $request->input('id'), 'status' => 'not_authorized'];
                return response($data);
    }
    if(($request->input('todo')) == 'user_start_authorize') {
        DB::table('users')
                ->where('id',$request->input('id'))
                ->update([
                    'status' => 'authorized',
                ]);
                $data = ['id' => $request->input('id'), 'status' => 'authorized'];
                return response($data);
    }

            }


    public function offers() {
        $reviews = new Offers();
        //dd($reviews->all()); // вывод всех данных их таблица (массив равный кол-ву записей в таблице)
        //DB::table('contact_models')->where('id', '=', 9)->update(['email' => 'dorofeev@inbox.ru']);
        return view('offers', ['offers' => $reviews -> all()]);
    }
    public function offer_subscribe(Request $request, Hande $action) {
        $action->offer_subscribe($request);


        //return redirect('all_offers');
    }
    public function offer_subscribe_ajax(Request $request, Hande $action) {

        $action->offer_subscribe($request);


         $resp = DB::table('offers')
         ->join('subscribes','subscribes.offer_id','=','offers.id')
         ->join('donors','donors.id','=','subscribes.donor_id')
         ->where('offers.id', $request->input('offer_uri_id'))
         ->where('donors.id', $request->input('select_offer'))
         ->where('subscribes.status', 'active')
         ->select('donors.id as donor_id', 'donors.uri', 'offers.id','offers.subscribs_amount','donors.offer_reference')
         ->get();

         $count_subscribes = DB::table('subscribes')
        ->select(DB::raw('offer_id, count(donor_id) as count'))
        ->join('donors','donors.id','=', 'subscribes.donor_id')
        ->join('users','users.id','=', 'donors.user_id')
        ->where('subscribes.status', '!=', 'deleted')
        ->groupBy('offer_id')->get()->pluck('count' , 'offer_id');

        $count = DB::table('donors')
        ->select(DB::raw('count(id) as count'))
        ->get();

        return response()->json(['resp' => $resp, 'count_subscribes' => $count_subscribes, 'count' => $count]);
        //return redirect('all_offers');
    }
    public function welcome() {

        return view(view:'welcome');
    }

    public function news_control(Request $request) {

    }

    public function offers_post_new (Request $request) {
         $messages = [
            'required'    => 'Поле :attribute обязательно.',
            'numeric' => 'Значение :attribute должно быть не меньше 1',
            'numeric' => 'Значение :attribute должно быть не больше 100',
            'max_digits' => 'Поле :attribute должно содержать не более 3-х цифр.',
            'min_digits' => 'Поле :attribute должно содержать минимум 1 цифру.',
            'numeric' => 'Значение :attribute должно быть в пределах от 1 и до 100',
            'numeric' => 'Поле :attribute значение должно быть не меньше 1',
            'active_url' => ' :attribute введите действующий активный URL',
            'unique' => '"Введенный URL" уже есть в базе, введите уникальный URL',

          ];


        $validator = Validator::make($request->all(), [
            'new_site_name' => 'required|max:100',
            'site_uri' => 'required|active_url|unique:offers',
            'new_site_theme' => 'required|min:1|max:100',
            'new_link_text' => 'required|min:1|max:100',
            'new_coast' => 'min:1|max:100|numeric',
        ], $messages);


        if ($validator->passes()) {
            $review = new Offers();
            $review->site_name = $request->input('new_site_name');
            $review->site_uri = $request->input('site_uri');
            $review->site_theme = $request->input('new_site_theme');
            $review->link_text = $request->input('new_link_text');
            $review->coast = $request->input('new_coast');
            $review->user_id = Auth::user()->id;
            $review->save(); // запись данных в таблицу Offers

            $offer_new = DB::table('offers')
            ->select(DB::raw('created_at, status, id, subscribs_amount'))
            ->where('site_name', $request->input('new_site_name'))
            ->where('site_uri', $request->input('site_uri'))
            ->where('site_theme', $request->input('new_site_theme'))
            ->where('coast', $request->input('new_coast'))
            ->get()->toArray();

            $data = [
            'site_name' => $request->input('new_site_name'),
             'site_uri' => $request->input('site_uri'),
             'site_theme' => $request->input('new_site_theme'),
             'link_text' => $request->input('new_link_text'),
             'coast' => $request->input('new_coast'),
             'created_at' => $offer_new[0]->created_at,
             'status' => $offer_new[0]->status,
             'id' => $offer_new[0]->id,
             'subscribs_amount' => $offer_new[0]->subscribs_amount,
            ];

            return response()->json($data);

        }

        return response()->json(['errors'=>$validator->errors()]);

    }

    public function offers_delete_ajax (Request $request) {


        //return response('$request');
        $id = $request->input('offer_id');
        $check = DB::table('subscribes')
        ->select('subscribes.id')
        ->join('offers', 'offers.id', '=', 'subscribes.offer_id')
        ->where('offers.id', $id)
        ->get()->toArray();
        //return response($check);
    if(empty($check)) {
        DB::table('offers')->where('id', '=', $id)->delete();
        return response($id);
    } else {
        DB::table('offers')->where('id', '=', $id)
        ->update(['status' => 'deleted']);
        return response($id);
    }


        /* $id = $request->input('offer_id');
        Offers::where('id', '=', $id)->delete();


        return response($id); */


        //return response(['site_name' => $request->input('new_site_name')]);


    }

    public function resources_controlajax (Request $request) {
        //return response($request);


        $validator = Validator::make($request->all(), [
            'new_uri' => 'required|min:14|max:100',
            'new_theme' => 'required|min:4|max:50',
            'new_coast' => 'min:1|max:100|numeric',
        ]);
        if ($validator->passes()) {

        //dd($valid);
        $id = $request->input('resourse_id');
        $uri = $request->input('new_uri');
        $coast = $request->input('new_coast');
        $theme = $request->input('new_theme');

            DB::table('donors')->where('id',$id)->update(['uri' => $uri]);
            DB::table('donors')->where('id',$id)->update(['coast' => $coast]);
            DB::table('donors')->where('id',$id)->update(['theme' => $theme]);

            return response()->json($request);

        }

        return response()->json(['errors'=>$validator->errors()]);
        }

        public function resourse_post_new_ajax (Request $request) {
            //return response($request);

            $messages = [
                'required'    => 'Поле :attribute обязательно.',
                'numeric' => 'Значение :attribute должно быть не меньше :value.',
                'numeric' => 'Значение :attribute должно быть не больше :max.',
                'max_digits' => 'Поле :attribute должно содержать не более :max цифр.',
                'min_digits' => 'Поле :attribute должно содержать минимум  :min цифр.',
                'numeric' => 'Значение :attribute должно быть в пределах от :min и до :max.',
                'active_url' => ' :attribute введите действующий активный URL',
                'unique' => '"Введенный URL" уже есть в базе, введите уникальный URL',

              ];

            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2|max:100',
                'uri' => 'required|min:14|max:100|unique:donors', // check for unique in DB!!!
                'theme' => 'required|min:4|max:200',
                'coast' => 'required|min:1|max:7|numeric|between:1,100000',


            ], $messages );



            if ($validator->passes()) {

                 $review = new Donors();
                $review->name = $request->input('name');
                $review->uri = $request->input('uri');
                $review->theme = $request->input('theme');
                $review->coast = $request->input('coast');
                $review->user_id = Auth::user()->id;
                $review->save();

                $id = DB::table('donors')
                ->select('id','created_at','status')
                ->where('name', $request->input('name'))
                ->where('uri', $request->input('uri'))
                ->where('theme', $request->input('theme'))
                ->where('coast', $request->input('coast'))
                ->get()->toArray();

                $data = [
                    'id' => $id[0]->id,
                    'created_at'=> $id[0]->created_at,
                    'status'=> $id[0]->status,
                    'uri'=> $request->input('uri'),
                    'name'=> $request->input('name'),
                    'theme'=> $request->input('theme'),
                    'coast'=> $request->input('coast'),

                ];


                return response()->json($data);

            }

            return response()->json(['errors'=>$validator->errors()]);
            }

            public function resource_delete_ajax (Request $request) {
                //return response('$request');
                 $id = $request->input('id');
                $check = DB::table('subscribes')
                ->select('subscribes.id')
                ->join('donors', 'donors.id', '=', 'subscribes.donor_id')
                ->where('donors.id', $id)
                ->get()->toArray();
                //return response($check);
            if(empty($check)) {
                DB::table('donors')->where('id', '=', $id)->delete();
                return response($request);
            } else {
                DB::table('donors')->where('id', '=', $id)
                ->update(['status' => 'deleted']);
                return response($request);
            }



                }



    }








