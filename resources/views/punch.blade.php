<!-- punch.blade.php -->
@extends('layout')

@section('title', '打卡')

@section('header')
    @parent
@endsection

@section('content')
<style>
    .title {
        font-size:80px;
    }
    .title a:link {
        color: #333333; 
        text-decoration: none;
    }
    .title a:hover {
        opacity: 0.7;
    }
    body {
        padding-top: 2rem;
        padding-bottom: 2rem;
    }
    h3 {
        margin-top: 2rem;
    }
    .row {
        margin-bottom: 1rem;
    }
    .row .row {
        margin-top: 1rem;
        margin-bottom: 0;
    }
    [class*="col-"] {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }
    hr {
        margin-top: 2rem;
        margin-bottom: 2rem;
    }
</style>

<div class="flex-center position-ref full-height">
    <div class="container">
        <div class="row title" style="margin-top: 100px">
            <div class="col-4">
                <p id="display-datetime" style="text-align: center;"></p>
                <p id="punch_year_month" style="display: none;"></p>
                <p id="punch_date" style="display: none;"></p>
                <p id="punch_time" style="display: none;"></p>
            </div>
        </div>

        <div class="row">
        @foreach($start_punch as $s)
            <div class="col-sm-4 title" style="text-align: center;">
                <a href="/punch/{{ $s->id }}">{{ $s->name }}</a>
                <div class="alert_{{ $s->id }} alert-warning" style="display:none; position: absolute; width: 90%; margin-left: 3%;" id="alertIp">
                    <a href="#" class="close">
                        &times;
                    </a><p class="errormsg_{{ $s->id }}" style="font-size: 18px;"></p>
                </div>
                <div class="links title">
                        @if (isset($s->start_time))
                            <button type="button" class="btn btn-primary btn-lg" disabled="true">上班</button>
                        @else
                            <button id='start' type="button" class="btn btn-primary btn-lg" value={{ $s->id }}>上班</button>
                        @endif
                        @if (isset($s->stop_time))
                            <button type="button" class="btn btn-success btn-lg" disabled="true">下班</button>
                        @else
                            <button id='stop' type="button" class="btn btn-success btn-lg" value={{ $s->id }}>下班</button>
                        @endif
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>
@endsection
@section('page-js-script')
<script type="text/javascript">
    $(document).ready(function () {
        setInterval(function(){
            var date = new Date();
            var format = "YYYY-MMM-DD DDD";
            dateConvert(date,format)
        }, 1);
        //$(".btn-primary").click({url: "{{ url('/punch/start_work/') }}"}, punch);
        //$(".btn-success").click({url: "{{ url('/punch/stop_work/') }}"}, punch);
        $(".btn-primary").click({url: "{{ URL::to('/punch/start_work/', array(), true) }}"}, punch);
        $(".btn-success").click({url: "{{ URL::to('/punch/stop_work/', array(), true) }}"}, punch);
    });

    function dateConvert(dateobj, format) {
        var year = dateobj.getFullYear();
        var month= ("0" + (dateobj.getMonth()+1)).slice(-2);
        var date = ("0" + dateobj.getDate()).slice(-2);
        var hours = ("0" + dateobj.getHours()).slice(-2);
        var minutes = ("0" + dateobj.getMinutes()).slice(-2);
        var seconds = ("0" + dateobj.getSeconds()).slice(-2);
        var day = dateobj.getDay();
        var months = ["01","02","03","04","05","06","07","08","09","10","11","12"];
        var converted_date = "";

        switch(format) {
            case "YYYY-MM-DD":
                converted_date = year + "-" + month + "-" + date;
                break;
            case "YYYY-MMM-DD DDD":
                converted_date = year + "-" + months[parseInt(month)-1] + "-" + date
                + " " + hours + ":" + minutes;
                break;
        }
        //return converted_date;
        // to show it I used innerHTMl in a <p> tag
        document.getElementById("display-datetime").innerHTML = converted_date;
        document.getElementById("punch_year_month").innerHTML = year + months[parseInt(month)-1];
        document.getElementById("punch_date").innerHTML = date;
        document.getElementById("punch_time").innerHTML = hours + ":" + minutes;
    }

    function punch (event) {
        let $id = $(this).attr("value");
        let $punch_year_month = document.getElementById("punch_year_month").innerHTML;
        let $punch_date = document.getElementById("punch_date").innerHTML;
        let $punch_time = document.getElementById("punch_time").innerHTML;
        var success_result;
        var element = this;
        var error_result;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data: { 
                "id" : $id , 
                "punch_year_month" : $punch_year_month , 
                "punch_date" : $punch_date,
                "punch_time" : $punch_time,
            },
            dataType: "json",
            url: event.data.url,
            success: function(result){
                $("[class^=alert_]").hide();
                $(element).attr("disabled", true);
            },
            error: function(result){
                if (result.status === 401) {
                    $("[class^=alert_]").hide();
                    $(".alert_"+$id).show();
                    $(".errormsg_"+$id).html("請確認您登入的IP" + result.responseText);
                }             
            }
        });
    }
</script>
@stop