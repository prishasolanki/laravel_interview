<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Prize;
use App\Http\Requests\PrizeRequest;
use App\Models\ActualPro;
use Illuminate\Http\Request;



class PrizesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $prizes = Prize::all();
        $proData = Prize::pluck('probability')->toArray();
        $proLabelsDatas= [];
        if(!empty($proData)) {
            foreach ($prizes as $label) {
                $proLabelsDatas[] = $label->title . '(' . ($label->probability) . ')';
            }
        }
        

        // actual Data count
        $actualDatas = [];
        $actualLabels = [];
        $actualData = ActualPro::latest()->first();
        if (!empty($actualData)) {
            $actual = json_decode($actualData->probabilities, true);

            $actualLabels = json_decode($actualData->labels, true);
// dd($actual);
            foreach ($actual as $ac) {
                $actualDatas[] = str_replace('"','', $ac);
                // dd($actualDatas);
            }
        }
           
        return view('prizes.index', ['prizes' => $prizes, 'proLabelsDatas' => $proLabelsDatas, 'proData' => $proData, 'actualDatas' => $actualDatas, 'actualLabels' => $actualLabels]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('prizes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PrizeRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PrizeRequest $request)
    {
        $prize = new Prize;
        $prize->title = $request->input('title');
        $prize->probability = floatval($request->input('probability'));
        $prize->save();

        return to_route('prizes.index');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $prize = Prize::findOrFail($id);
        return view('prizes.edit', ['prize' => $prize]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PrizeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PrizeRequest $request, $id)
    {
        $prize = Prize::findOrFail($id);
        $prize->title = $request->input('title');
        $prize->probability = floatval($request->input('probability'));
        $prize->save();

        return to_route('prizes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $prize = Prize::findOrFail($id);
        $prize->delete();

        return to_route('prizes.index');
    }

    public function simulate(Request $request)
    {
        $proLabels = Prize::get();
        foreach ($proLabels as $pro) {
            $labels[] = Prize::nextPrize($pro->probability, $request->number_of_prizes);
            $actualData[] = json_encode($pro->title . '(' . (Prize::nextPrize($pro->probability, $request->number_of_prizes)) . ')');
        }
        // dd($actualData);
        $ac = new ActualPro;
        $ac->number_of_prize = $request->number_of_prizes;
        $ac->labels = json_encode($labels);
        $ac->probabilities = json_encode($actualData);
        $ac->save();


        return to_route('prizes.index');
    }

    public function reset()
    {
        // TODO : Write logic here
        return to_route('prizes.index');
    }
}
