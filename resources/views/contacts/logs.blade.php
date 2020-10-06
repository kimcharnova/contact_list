@extends('base')
@section('main')
<div class="row">
<div class="col-sm-12">
    <h1 class="display-3">Activity Logs</h1>    
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Created At</td>
          <td>ID Modified</td>
          <td>Status</td>
        </tr>
    </thead>
    <tbody>
        @foreach($activity_log as $activity)
        <tr>
            <td>{{$activity->id}}</td>
            <td>{{$activity->created_at}}</td>
            <td>{{$activity->id_modified}}</td>
            <td>{{$activity->status}}</td>
        </tr>
        @endforeach
    </tbody>
  </table>
@endsection
