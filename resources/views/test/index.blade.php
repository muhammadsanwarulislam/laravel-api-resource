@extends('test.layouts.app')

@section('title') {{ __($module_action) }} {{ $module_title }} @stop

@section('breadcrumbs')

@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="fa fa-list"></i> {{ $module_title }} <small class="text-muted">{{ __($module_action) }}</small>
                </h4>
                <div class="small text-muted">
                    @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
                </div>
            </div>
            <!--/.col-->
            <div class="col-4">
                <div class="float-right">
                    <a href="{{ route("test.create") }}" class="btn btn-success btn-lg" title="Create">
                        <span class="fa fa-plus-circle"> Create</span>
                    </a>                 
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <div class="row mt-4">
            <div class="col">
                <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Title
                            </th>
                            <th>
                                Description
                            </th>

                            <th class="text-left">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @if($data->count()>0)
                        @foreach($data as $key =>$test)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $test->title }}</td>
                            <td>{{ $test->description }}</td>

                            <td>
                                <a href="{{route('test.edit',$test->id)}}" class="btn btn-success btn-sm" title="Edit">
                                  <span class="fa fa-edit"></span>
                              </a>

                              <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$test->id}}" title="Delete">
                                  <span class="fa fa-trash"></span>
                              </a>
                          </td>
                        </tr>

                        <!-- Delete Modal -->
                        <div id="deleteModal{{$test->id}}" class="modal fade">
                          <div class="modal-dialog modal-confirm">
                            <div class="modal-content">
                              <div class="modal-header">
                                        <h4 class="modal-title">Are you sure?</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </div>
                                    <div class="modal-body">
                                        <p>Do you really want to delete these records? This process cannot be undone.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route("test.destroy",$test->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Delete Modal -->

                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>
@stop
