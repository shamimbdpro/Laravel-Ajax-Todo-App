<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\todolist;
use Session;
class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
     $todoinfo = todolist::orderBy('id','ASC')->get();
     $activeTask = todolist::where('status','1')->get();
     $Taskcompleted = todolist::where('status','0')->get();
     $leftTask = todolist::where('status','1')->count();
     return view('welcome', compact('todoinfo','activeTask','Taskcompleted','leftTask'));
    }


     public function deactive($id){

        $enactive=todolist::where('status',1)->where('id',$id)->update([
          'status' => 0,
        ]);
         return ['success'=>true, 'message' => $id];
        
       
      }
      public function active($id){
          $active=todolist::where('status',0)->where('id',$id)->update([
            'status' => 1,
          ]);
          return redirect()->back();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        todolist::create($input);
        return ['success'=>true, 'message' => 'data inserted successfully'];
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $input = $request->input('data');
        $enactive=todolist::where('id',$id)->update([
          'title' => $input,
        ]);
        return ['success'=>true, 'message' => $input];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        todolist::destroy($id);
        $shamim = "Deleted";
        return response()->json($shamim);
        
    }

    public function delteAll(){
        $delete=todolist::where('status',0);
        $delete->delete();
        $shamim = "Deleted All";
        return response()->json($shamim);
    }
}
