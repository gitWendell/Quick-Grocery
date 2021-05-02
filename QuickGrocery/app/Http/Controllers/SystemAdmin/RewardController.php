<?php

namespace App\Http\Controllers\SystemAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SystemAdmin\Reward\RewardCreate;
use App\Reward;
use App\Services\SystemAdmin\RewardServices;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use PDF;

class RewardController extends Controller
{
    //
    public function show() {
        $reward = Reward::all();

        return view('systemadmin.reward')
                    ->with('rewards', $reward);
    }

    //
    public function create(RewardCreate $request, RewardServices $rewardServices) {

        if($request['startDate'] > $request['endDate']) {
            $error = ValidationException::withMessages([
                'startDate' => 'Start Date must be lesser than End Date'
            ]);

            throw $error;
        }

        if($request['startDate'] < Carbon::now()->toDateString()) {
            $error = ValidationException::withMessages([
                'startDate' => 'Start Date cannot be past date'
            ]);

            throw $error;
        }

        Reward::create($rewardServices->create($request));

        return redirect()->back()
                ->with('success', 'Reward added');
    }

    public function delete($id) {
        Reward::where('id', $id)->delete();
    }

    public function generatePDF() {
        $reward = Reward::all();

        // share data to view
        view()->share('rewards',$reward);
        $pdf = PDF::loadView('PDF.systemadmin.RewardPDF', $reward);

        // download PDF file with download method
        return $pdf->stream('pdf_file.pdf');
    }
}
