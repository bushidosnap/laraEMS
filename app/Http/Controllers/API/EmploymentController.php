<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employment;
use App\Models\User;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EmploymentRequest;

class EmploymentController extends Controller
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
        return Employment::with('user','position', 'department')->latest()->paginate(10);
    }

    public function myEmployment()
    {
        $user = auth('api')->user()->id;
        
        return Employment::with('user','position', 'department')->where('employments.user_id',$user)->get();
        // $myEmployment = DB::table('employments')
        //     ->join('users', 'employments.user_id','users.id')
        //     ->join('positions', 'employments.pos_id','positions.id')
        //     ->join('departments', 'employments.dept_id','departments.id')
        //     ->where('employments.user_id', $user)
        //     ->where('employments.status', 1)
        //     ->get();
        // return $myEmployment;   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmploymentRequest $request)
    {
        return Employment::create([
            'user_id' => $request->user_id,
            'dept_id' => $request->dept_id,
            'pos_id' => $request->pos_id,
            'emp_type' => $request->emp_type,
            'contract_start' => $request->contract_start,
            'contract_end' => $request->contract_end,
            'status' => $request->status,
        ]);
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
    public function update(EmploymentRequest $request, $id)
    {
        $validated = $request->validated();
        $employment = Employment::findOrFail($id);
        $employment->update($validated);
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
