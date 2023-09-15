<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\User;
// use Carbon;
use Carbon\Carbon as CarbonCarbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\Break_;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user = User::all();
        $user = User::find(Auth::id());
        $data = array();

        $today = now()->toDateString();
        $att_record = Attendance::where('user_id',Auth::user()->id)->whereDate('created_at',$today)->get();


        if(isset($att_record[0]->end_flag) && $att_record[0]->end_flag=="1")
        {
            $createdAt = Carbon::parse($att_record[0]->created_at);
            $updatedAt = Carbon::parse($att_record[0]->updated_at);

            $diff = $createdAt->diffForHumans($updatedAt);
            return view('home', compact('user','att_record','diff'));
        }


        $date = new DateTime();

        return view('home', compact('user','att_record'));
    }
    public function adminHome()
    {
        $user = User::all();
        $user = User::find(Auth::id());
        $attendances = Attendance::select('attendances.created_at','attendances.updated_at','users.name')
                        ->join('users','attendances.user_id','=','users.id')
                        ->orderBy('attendances.created_at','DESC')
                        ->get();

        foreach ($attendances as $key => $value) {
            $createdAt = Carbon::parse($value->created_at);
            $updatedAt = Carbon::parse($value->updated_at);
            $totalDuration = $updatedAt->diffInSeconds($createdAt);
            $attendances[$key]['duration'] = gmdate('H:i:s',$totalDuration);
        }

        return view('admin', compact('attendances'));
    }

    public function superadminHome()
    {
        {
            $user = User::all();
            $user = User::find(Auth::id());
            $attendances = Attendance::select('attendances.created_at','attendances.updated_at','users.name')
                            ->join('users','attendances.user_id','=','users.id')
                            ->orderBy('attendances.created_at','DESC')
                            ->get();
    
            foreach ($attendances as $key => $value) {
                $createdAt = Carbon::parse($value->created_at);
                $updatedAt = Carbon::parse($value->updated_at);
                $totalDuration = $updatedAt->diffInSeconds($createdAt);
                $attendances[$key]['duration'] = gmdate('H:i:s',$totalDuration);
            }
    
            return view('superadmin', compact('attendances'));
        }
        // return view('superadmin');
    }



  



    public function storeAttendance(Request $request){




        $today = now()->toDateString();

        

        $timeDifference = "";


        if($request->type === 'start'){
                $a = new Attendance();
                $a->start_flag = "1";
                $a->user_id = Auth::user()->id;
                $a->save();
        }

        if($request->type === 'stop'){

            

            $a = Attendance::where('user_id',Auth::user()->id)->whereDate('created_at',$today)->update(
                ['end_flag'=>"1"]
            );


            

            // return $timeDifference;

            $att_record = Attendance::where('user_id',Auth::user()->id)->whereDate('created_at',$today)->get();

            $createdAt = Carbon::parse($att_record[0]->created_at);
            $updatedAt = Carbon::parse($att_record[0]->updated_at);

            $timeDifference = $createdAt->diffForHumans($updatedAt);
            

            return Redirect::back()->with(['att_record'=>$att_record,'diff'=>$timeDifference]);
            
        }


        $att_record = Attendance::where('user_id',Auth::user()->id)->whereDate('created_at',$today)->get();

        return Redirect::back()->with(['att_record'=>$att_record,'diff'=>$timeDifference]);

    
    }
}




