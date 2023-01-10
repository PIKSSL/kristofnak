<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LDAP\Result;

class ReservationController extends Controller
{
         //
         public function index(){
            $lendings =  Reservation::all();
            return $lendings;
        }
    
        public function show ($user_id, $book_id, $start)
        {
            $reservation = Reservation::where('user_id', $user_id)->where('book_id', $book_id)->where('start', $start)->get();
            return $reservation[0];
        }
        public function destroy($user_id, $book_id, $start)
        {
            ReservationController::show($user_id, $book_id, $start)->delete();
        }
        public function deleteOldOnes(){
            $reservations = DB::table('reservation r')
            ->where('status',1)->delete();
            return $reservations;
        }
    
        public function store(Request $request)
        {
            $reservation = new Reservation();
            $reservation->user_id = $request->user_id;
            $reservation->copy_id = $request->copy_id;
            $reservation->start = $request->start;
            $reservation->save();
        }
    
        public function update(Request $request, $user_id, $book_id, $start)
        {
            $reservation = ReservationController::show($user_id, $book_id, $start);
            $reservation->user_id = $request->user_id;
            $reservation->copy_id = $request->copy_id;
            $reservation->start = $request->start;
            $reservation->end = $request->end;
            $reservation->extension = $request->extension;
            $reservation->notice = $request->notice;
            $reservation->save();
        }

        public function reservations_per_user(){
            $user = Auth::user();
            $reservation = DB::table('reservations as r')
            ->where('r.user_id','=',$user->id)
            ->count();
            return $reservation;
        }

        public function thrday(){
            $user = Auth::user();
            
            $reservation = DB::table('reservations as r')
            ->select('r.*')
            ->where('user_id','=',$user)
            //->where(now()->diffInDays(Carbon::parse('r.start','GMT')->format('Y-m-d')),'>','3')
            ->get();
            return $reservation;
        }

        public function hossz(){
            
        }

        public function reservUsers(){
            $reservation = DB::table('reservation r')
            ->join('user as u','u.id','r.user.id')
            ->selectRaw('u.name, u.email, count(*) as db')
            ->groupBy('u.name, u.email')
            ->get();
            return $reservation;
        }

        public function mybooks(){
            $user = Auth::user();
            $result = DB::table('lendings r')
            ->join('copies c','c.copy_id','=','r.copy_id')
            ->join('books b','b.book_id','=','c.book_id')
            ->select('b.author','b.title')
            ->where('l.user_id','=',$user->id)
            ->whereRaw('l.end is null')
            ->get();
            return $result;
        }
}
