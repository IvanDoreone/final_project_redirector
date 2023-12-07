<?php
namespace App\Actions;

use App\Models\ContactModel;
use App\Models\NewsModel;
use App\Models\Transitions;
use App\Models\Declanes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use function PHPUnit\Framework\isEmpty;

//Log::channel('slack')->error('Что-то случилось!');
class Hande2 {

    public $date = 'example/example/example/hande2';
    public $summ = 456;
    public function __construct($date) {
    $this->date = $date;
    }
    public function summa ($a) {
        return $this->summ = $a*10;
            }

    public function hand() {
        $posts = DB::table('offers') -> where('ID' , '>' , 0) -> get();
        return $posts;

    }
    public function redirect($request) {
        $donor = $request->server->get('HTTP_REFERER');
        $subscribe = $request->get('link');

        $check = DB::table('subscribes')
        ->join('offers','offers.id','=','subscribes.offer_id')
        ->join('donors','donors.id','=','subscribes.donor_id')
        ->select('subscribes.donor_id','subscribes.offer_id', 'subscribes.status', 'donors.uri', 'donors.id as donor_id', 'offers.site_uri', 'donors.status as donor_status', 'offers.status as offer_status', 'subscribes.coast', 'subscribes.id')
        ->where('subscribes.id','=', $subscribe)
         ->get()->toArray();
        //dd($check[0]->uri);
         if(isset($check[0]) && $check[0]->status == 'active' && $donor == $check[0]->uri && $subscribe == $check[0]->id && $check[0]->donor_status == 'approved' && $check[0]->offer_status == 'active' && $check[0]->status == 'active') {
            Log::channel('custom')->info('success click', ['webmaster`s page' => $donor, 'client`s page' => $check[0]->site_uri, 'subscribe_id' => $subscribe, 'transition_coast' => $check[0]->coast]);
            Log::channel('custom_success')->info('success transition', ['webmaster`s page' => $donor, 'client`s page' => $check[0]->site_uri, 'subscribe_id' => $subscribe, 'transition_coast' => $check[0]->coast]);
            $transition = new Transitions();
            $transition->subscribes_id = $subscribe;
            $transition->save();
            $redirect_uri = $check[0]->site_uri;
            return $redirect_uri;

         } elseif(isset($check[0]) && $check[0]->status != 'active' && $donor == $check[0]->uri && $subscribe == $check[0]->id && $donor == $check[0]->uri ) {
            Log::channel('custom')->alert('not active subscribe transition attempt', ['webmaster`s page' => $donor, 'client`s page' => $check[0]->site_uri, 'subscribe_id' => $subscribe, 'transition_coast' => $check[0]->coast]);
            return '404';
         }elseif(isset($check[0]) && $check[0]->donor_status != 'approved' && $donor == $check[0]->uri && $subscribe == $check[0]->id ) {
            Log::channel('custom')->alert('not approved donor`s url subscribe transition attempt', ['webmaster`s page' => $donor, 'client`s page' => $check[0]->site_uri, 'subscribe_id' => $subscribe, 'transition_coast' => $check[0]->coast]);
            return '404';
         }
         elseif(isset($check[0]) && $check[0]->offer_status != 'active' && $donor == $check[0]->uri && $subscribe == $check[0]->id ) {
            Log::channel('custom')->alert('not active client`s offer subscribe transition attempt', ['webmaster`s page' => $donor, 'client`s page' => $check[0]->site_uri, 'subscribe_id' => $subscribe, 'transition_coast' => $check[0]->coast]);
            return '404';
         }
         elseif(!isset($check[0])) {
            Log::channel('custom')->emergency('unexisted link transition attempt', ['webmaster`s page' => $donor, 'link_input_to_redirect' => $subscribe]);
            return '404';
         }
            elseif( ($donor != $check[0]->uri || $subscribe != $check[0]->id || $check[0]->status == 'deleted')) {
            Log::channel('custom')->emergency('unregistred subscribe transition attempt', ['webmaster`s page' => $donor, 'subscribe_id' => $subscribe]);
            Log::channel('custom_decline')->emergency('decline: web master tried to redirected on unsubscribed link', ['webmaster`s page' => $donor, 'subscribe_id' => $subscribe, 'redirected_url' => $check[0]->site_uri, 'donor_id' => $check[0]->donor_id]);
            $decline = new Declanes();
            $decline->subscribes_id = $subscribe;
            $decline->donor_id = $check[0]->donor_id;
            $decline->save();
            return '404';
         }
         else
         return '404';

    }

}
