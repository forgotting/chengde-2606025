<!-- quote.blade.php -->
@extends('layout')

@section('title', '報價')

@section('header')
    @parent
@endsection

@section('content')
<style>
    .word_style {
        color: red; 
        font-weight: 1000;
        font-size: 150%;
    }
    .input_style {
        width: 80%; 
        font-size: 30px;
    }
    h2 {
        
    }
</style>

<div class="flex-center position-ref full-height">
    @include('login')
    <div class="content">
        {!! Form::open(['url' => url('/quote/'.Request::route('id')), 'method' => 'post']) !!}
        {{ Form::hidden('id', Request::route('id')) }}
        <table border="1">
            <tr>
                <td rowspan="6" width="200">
                    <div class="dropdown">
                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">
                            客戶名稱
                                @if (isset($customer_name))
                                    ( {{ $customer_name }} )
                                @endif
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" style="background: #f4511e; width: 200px;">
                            <li><a href="/quote/1">一般客戶</a></li>
                            <li ><a href="/quote/2">凱一</a></li>
                            <li><a href="/quote/3">東揚</a></li>
                            <li><a href="/quote/4">鶴強</a></li>
                        </ul>
                    </div>
                </td>
                <td width="50" style="background-color: #5bc0de; color:#ffffff;">
                    @if (isset($customer_name))
                        <h3>{{ $customer_name }}</h3>
                    @endif
                </td>
                <td width="150" colspan="4" style="background-color: #5bc0de;">
                    <p class="word_style" style="padding-top: 10px; color:#ffffff;">
                        樹脂版：
                        @if (isset($resin_price))
                            {{ $resin_price }}元
                        @endif
                        &nbsp;&nbsp;
                        橡膠版：
                        @if (isset($rubber_price))
                            {{ $rubber_price }}元
                        @endif
                    </p>
                </td>
            </tr>
            <tr>
                <td width="150"><p class="word_style">長度與寬度</p></td>
                <td width="100" align="left" style="padding-left: 1%;">
                    {!! Form::radio('use_type', 'resin4', ($use_type == 'resin4') ? true : false, ['id' => 'resin4']) !!}
                    {!! Form::label('radio1', '樹脂版0.4') !!}
                    &nbsp;
                    {!! Form::radio('use_type', 'resin7', ($use_type == 'resin7') ? true : false, ['id' => 'resin7']) !!}
                    {!! Form::label('radio1', '樹脂版0.7') !!}
                    &nbsp;
                    {!! Form::radio('use_type', 'rubber', ($use_type == 'rubber') ? true : false, ['id' => 'rubber']) !!}
                    {!! Form::label('radio2', '橡膠版') !!}
                </td>
                <td width="70" align="left" style="padding-left: 1%;">
                    {!! Form::radio('use_half', '1', ($use_half == '1') ? true : false) !!}
                    {!! Form::label('radio3', '半版') !!}
                    &nbsp;
                    {!! Form::radio('use_half', '2', ($use_half == '2') ? true : false) !!}
                    {!! Form::label('radio4', '全版') !!}
                </td>
                <td width="80" align="left" style="padding-left: 1%;">
                    {!! Form::radio('use_script', 'false', ($use_script == 'false') ? true : false) !!}
                    {!! Form::label('radio5', '無稿費') !!}
                    &nbsp;
                    {!! Form::radio('use_script', 'true', ($use_script == 'true') ? true : false) !!}
                    {!! Form::label('radio6', '有稿費') !!}
                </td>
                <td width="200" align="center">
                    {!! Form::label('word_length', '長度(cm):') !!}
                    {!! Form::number('word_length', $word_length, ['class' => 'form-control input_style', 'step' => '0.1']) !!}
                    {!! Form::label('word_width', '寬度(cm):') !!}
                    {!! Form::number('word_width', $word_width, ['class' => 'form-control input_style', 'step' => '0.1']) !!}
                    <br>
                </td>
            </tr>
            <tr>
                <td width="150"><p class="word_style">其他費用</p></td>
                <td width="170" align="center" colspan=2>
                    {!! Form::number('other_price', $other_price, ['class' => 'form-control input_style', 'style' => 'margin-top: 17px;']) !!}
                    <br>
                </td>
                <td width="80"><p class="word_style">折扣%</p></td>
                <td width="200" align="center">
                    {!! Form::number('discount', $discount == 100 ? '' : $discount, ['class' => 'form-control input_style', 'style' => 'margin-top: 17px;']) !!}
                    <br>
                </td>
            </tr>
            <tr>
                <td width="150"><p class="word_style">中文黑體字</p></td>
                <td width="250" align="center" colspan=4>
                    {!! Form::label('c_word_count', '字數:') !!}
                    {!! Form::number('c_word_count', $c_word_count, ['class' => 'form-control input_style']) !!}
                    {!! Form::label('c_word_height', '字體高度(cm):') !!}
                    {!! Form::number('c_word_height', $c_word_height, ['class' => 'form-control input_style', 'min' => 1, 'max' => 6, 'step' => '0.1']) !!}
                    <br>
                </td>
            </tr>
            <tr>
                <td width="150"><p class="word_style">英文黑體字</p></td>
                <td width="250" align="center" colspan=4>
                    {!! Form::label('eb_word_count', '字數:') !!}
                    {!! Form::number('eb_word_count', $eb_word_count, ['class' => 'form-control input_style']) !!}
                    {!! Form::label('eb_word_height', '字體高度(cm):') !!}
                    {!! Form::number('eb_word_height', $eb_word_height, ['class' => 'form-control input_style', 'min' => 1, 'max' => 6, 'step' => '0.1']) !!}
                    <br>
                </td>
            </tr>
            <tr>
                <td width="150"><p class="word_style">英文美術字</p></td>
                <td width="250" align="center" colspan=4>
                    {!! Form::label('e_word_count', '字數:') !!}
                    {!! Form::number('e_word_count', $e_word_count, ['class' => 'form-control input_style']) !!}
                    {!! Form::label('e_word_height', '字體高度(cm):') !!}
                    {!! Form::number('e_word_height', $e_word_height, ['class' => 'form-control input_style', 'min' => 1, 'max' => 6, 'step' => '0.1']) !!}
                    <br>
                </td>
            </tr>           
        </table>
        <br>
        <a class="btn btn-primary btn-lg" href="{{ url()->previous() }}" style="margin-right: 50px;">取消</a>
        {!! Form::submit('送出', ['class' => 'btn btn-success btn-lg']) !!}
        {!! Form::close() !!}
    </div>
</div>

<script type="text/javascript">
    
</script>
@endsection