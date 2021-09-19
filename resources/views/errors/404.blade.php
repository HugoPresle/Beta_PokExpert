@extends('layouts.header')
@section('content')
    <div>
        <h1 style="text-align: center"> PAGE NOT FOUND</h1>
        <h5 style="text-align: center">Sorry but the page you are looking for does not exist, have been removed. name changed or is temporarily unavailable.</h5> 
        <h6 style="text-align: center; color: red">Click ont the ball to go Home</h6>
    </div>
    <div class="center-on-page">
        <a href="/">
            <div class="pokeball">
                <div class="pokeball__button"></div>
            </div>
        </a>    
    </div>
@endsection
<style>
    *, *:before, *:after 
    {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    body {
        background: #ecf0f1;
    }
    .center-on-page 
    {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
    }
    /* Poké Styles */
    .pokeball 
    {
        position: relative;
        width: 200px;
        height: 200px;
        background: #fff;
        border: 10px solid #000;
        border-radius: 50%;
        overflow: hidden;
        box-shadow: inset -10px 10px 0 10px #ccc;
        animation: fall .25s ease-in-out,
                    shake 1.25s cubic-bezier(.36,.07,.19,.97) 3;
    }
    .pokeball::before,
    .pokeball::after 
    {
        content:"";
        position: absolute;
    }
    .pokeball::before 
    {
        background: red;
        width: 100%;
        height: 50%;
    }
    .pokeball::after 
    {
        top: calc(50% - 10px);
        width: 100%;
        height: 20px;
        background: #000;
    }
    .pokeball__button 
    {
        position: absolute;
        top: calc(50% - 30px);
        left: calc(50% - 30px);
        width: 60px;
        height: 60px;
        background: #7f8c8d;
        border: 10px solid #fff;
        border-radius: 50%;
        z-index: 10;
        box-shadow: 0 0 0 10px black;
        animation: blink .5s alternate 7;
    }
    /* Animation */
    @keyframes blink 
    {
        from { background: #eee;}
        to { background: #e74c3c; }
    }
    @keyframes shake 
    {
        0 { transform: translate(0, 0) rotate(0); }
        20% { transform: translate(-10px, 0) rotate(-20deg); }
        30% { transform: translate(10px, 0) rotate(20deg); }
        50% { transform: translate(-10px, 0) rotate(-10deg); }
        60% { transform: translate(10px, 0) rotate(10deg); }
        100% { transform: translate(0, 0) rotate(0); }
    }
    @keyframes fall 
    {
        0% { top: -200px }
        60% { top: 0 }
        80% { top: -20px }
        100% { top: 0 }
    }
</style>