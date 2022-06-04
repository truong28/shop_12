@extends('admin.main')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>ACTIVE</th>
                <th>UPDATE</th>
                <th style="width:150px;">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            {!! \App\Helpers\Helper::menu($menus)!!}
        </tbody>
    </table>
    {!! $menus->links() !!}
@endsection


