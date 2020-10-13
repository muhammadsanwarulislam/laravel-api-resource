<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FirstModel;
use Flash;

class SpatieFormController extends Controller
{
    public function __construct()
    {
        // Page Title
        $this->module_title = 'Spatie Form Data';

        // module name
        $this->module_name = 'list of data';

        // directory path of the module
        $this->module_path = 'list of data';

        // module icon
        $this->module_icon = 'fa fa-file-alt';

        // module model name, path
        $this->module_model = "App\Models\FirstModel";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $module_title           = $this->module_title;
        $module_name            = $this->module_name;
        $module_path            = $this->module_path;
        $module_icon            = $this->module_icon;
        $module_model           = $this->module_model;

        $module_action          = 'List';

        $data           = $module_model::orderby('id','desc')->get();

        return view("test.index",compact(
            'module_title',
            'module_name',
            'module_icon',
            'module_action',
            'module_path',
            'data'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $module_title   = $this->module_title;
        $module_name    = $this->module_name;
        $module_path    = $this->module_path;
        $module_icon    = $this->module_icon;
        $module_model   = $this->module_model;

        $module_action  = 'Create';

        return view("test.create", compact(
          'module_path',
          'module_title',
          'module_action',
          'module_name',
          'module_icon'
      ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $module_name     = $this->module_name;
        $module_model    = $this->module_model;
        $module_path     = $this->module_path;

        $module_model::create([
          'title'                    => $request->title,
          'description'                   => $request->description,

        ]);

        // Flash::success("<i class='fas fa-check'></i> New Item Added")->important();

        return redirect()->route("test.index");
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
        $module_title   = $this->module_title;
        $module_name    = $this->module_name;
        $module_path    = $this->module_path;
        $module_icon    = $this->module_icon;
        $module_model   = $this->module_model;        

        $list_of_test           = $module_model::findOrFail($id);

        $module_action  = 'Update';

        return view("test.edit", compact(
          'list_of_test',
          'module_title',
          'module_action',
          'module_name',
          'module_icon',
          'module_path'
      ));
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
        $module_model   = $this->module_model;
        $module_path    = $this->module_path;

        $list_of_test   = $module_model::findOrFail($id);

        $list_of_test->update([
          'title'                    => $request->title ? $request->title : $list_of_test->title,
          'description'                   => $request->description ? $request->description : $list_of_test->description,
        ]);

        // Flash::success("<i class='fas fa-check'></i>Symptoms and Score Updated")->important();
        return redirect()->route("test.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $module_model    = $this->module_model;
      $data = $module_model::find($id);
      $data->delete();
      return back();  
    }
}
