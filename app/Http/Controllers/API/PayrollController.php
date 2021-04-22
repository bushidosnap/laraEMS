<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\Employment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Importer;
use Validator;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        return Payroll::with(['employment.user' => function ($query) {
            $query->select('id','name');
        }])->with(['employment.department' => function ($query) {
            $query->select('id','dept_name');
        }])->with( ['employment.position' => function ($query) {
            $query->select('id','position_name', 'salary');
        }])->orderBy('employment_id')->paginate(10);
    }

    public function getPayroll(Request $request)
    {
        return Payroll::where('id',$request->payroll_id)->get();
    }
    public function myPayrolls()
    {
        return Payroll::where('employment_id', Auth::user()->employment->id)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $fileName = time().'-'.$request->file->getClientOriginalName().'.'.$request->file->getClientOriginalExtension();
        $savePath = public_path('/storage/payrollFile/');
        $request->file->move($savePath, $fileName);
        
        $excel = Importer::make('Excel');
        $excel->load($savePath.$fileName);
        $collection = $excel->getCollection();

        if(sizeof($collection[1]) == 7){
            for($row=1; $row<sizeof($collection); $row++){
                try{
                    return $collection[$row];
                    //var_dump($collection[$row]);
                    //eturn response()->json(['success'=>'You have successfully upload file.']);
                }catch(Exception $e){
                    return response()->json(['error'=>$e->getMessage()]);
                }
            }
        }

        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
