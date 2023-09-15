<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif 


                    <!-- {{ __('You are logged in!') }} -->
                    {{ Auth::user()->name }}
                    <!-- <button type="button" name="start_time" onclick="startTime" class="btn btn-success">Start</button> -->
                   
                    <form action="/submitAttendance" method="POST" enctype="multipart/form-data">
                        @csrf
                    <input type="hidden" name="type" value="start">
                    <button type="submit" class="btn btn-success" @if(isset($att_record[0]->start_flag) && $att_record[0]->start_flag=== "1") disabled @endif>Start</button>
                    </form>

                    <br>

                    <form action="/submitAttendance" method="POST" enctype="multipart/form-data">
                        @csrf
                    <input type="hidden" name="type" value="stop">
                    <button type="submit" class="btn btn-success" @if(isset($att_record[0]->end_flag) && $att_record[0]->end_flag=="1") disabled @endif>Stop</button>
                    </form>

                    @if(isset($att_record[0]->end_flag) && $att_record[0]->end_flag=="1")

                    

                    <h6>Duration : {{$diff}}</h6>

                    @endif

                  

            


                    
                </div>
            </div>
        </div>
    </div>
</div>







@endsection



</body>
</html>

