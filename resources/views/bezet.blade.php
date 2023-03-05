@extends('layouts.app')

@section('head')
    @foreach($washers as $washer)
        @if($washer->state != 'stop')
            <style>
                #washer-{{ $washer->id }} #circlepath {
                    animation: turn {{ $washer->duration() }}s linear infinite;
                    animation-delay: -{{ \Carbon\Carbon::now()->diffInSeconds($washer->start) }}s;
                }
            </style>
        @endif
    @endforeach
@endsection

@section('content')
    <div class="mb-5 p-5 bg-dark text-white" style="margin-top: -3rem;">
        <div class="container">
            <h1 class="display-4">Is het toilet bezet?</h1>
            <h2>(of de wasmachine?)</h2>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a class="btn {{ auth()->user()->notify_washer ? 'btn-danger' : 'btn-primary' }}"
                   href="{{route('user.notify_washer')}}">Notify washer</a>
                <a class="btn {{ auth()->user()->notify_toilet ? 'btn-danger' : 'btn-primary' }}"
                   href="{{route('user.notify_toilet')}}">Notify toilet</a>
            </div>

        </div>
        <br>
        <div class="row">

            @foreach($toilets as $toilet)
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $toilet->name }}</h4>
                        </div>
                        <div class="card-body">
                            <svg class="card-img-bottom" xmlns="http://www.w3.org/2000/svg" width="200" height="200"
                                 viewBox="0 0 100 100" version="1.1">
                                <circle cx="50" cy="50" r="50" fill="#5e5e5e"/>
                                <path fill="none" stroke="{{ $toilet->free ? '#0ea800' : 'red'}}" stroke-width="10"
                                      stroke-linecap="round" d="M30,25 a30,30 0 0,1 40,0"/>
                                <circle cx="50" cy="50" r="20" fill="#808080"/>
                                <line
                                    {!! $toilet->free ? 'x1="50" y1="35" x2="50" y2="65"' : 'x1="35" y1="50" x2="65" y2="50"' !!} stroke="#474747"
                                    stroke-width="5" stroke-linecap="round"/>
                            </svg>
                        </div>
                    </div>
                </div>
            @endforeach
            @foreach($washers as $washer)
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $washer->name }}</h4>
                        </div>
                        <div class="card-body">
                            <svg id="washer-{{ $washer->id }}" class="card-img-bottom washer {{$washer->jobState}}"
                                 xmlns="http://www.w3.org/2000/svg"
                                 width="200"
                                 viewBox="7.5 7.5 105 125">
                                <defs>
                                    <clipPath id="washer-window">
                                        <circle cx="60" cy="80" r="27.5" stroke="black" stroke-width="5"
                                                fill="lightblue"/>
                                    </clipPath>
                                    <g id="bubble">
                                        <circle cx="-2.5" cy="-2.5" r="5" stroke="white" stroke-width="1"
                                                fill="darkgrey"
                                                opacity="50%"/>
                                        <circle cx="-4" cy="-4" r="2" stroke="none" fill="white" opacity="50%"/>
                                    </g>
                                    <g id="bubbles">
                                        <use xlink:href="#bubble" transform="translate(70, 60) scale(0.8)"/>
                                        <use xlink:href="#bubble" transform="translate(83, 75) scale(0.9)"/>
                                        <use xlink:href="#bubble" transform="translate(60, 80) scale(1.0)"/>
                                        <use xlink:href="#bubble" transform="translate(50, 95) scale(1.1)"/>
                                        <use xlink:href="#bubble" transform="translate(43, 60) scale(1.0)"/>
                                        <use xlink:href="#bubble" transform="translate(75, 99) scale(0.9)"/>
                                        <use xlink:href="#bubble" transform="translate(78, 86) scale(0.4)"/>
                                        <use xlink:href="#bubble" transform="translate(70, 90) scale(0.5)"/>
                                        <use xlink:href="#bubble" transform="translate(66, 70) scale(0.6)"/>
                                        <use xlink:href="#bubble" transform="translate(50, 70) scale(0.4)"/>
                                        <use xlink:href="#bubble" transform="translate(60, 95) scale(0.5)"/>
                                        <use xlink:href="#bubble" transform="translate(38, 88) scale(0.7)"/>
                                        <use xlink:href="#bubble" transform="translate(70, 80) scale(0.8)"/>
                                        <use xlink:href="#bubble" transform="translate(35, 76) scale(0.7)"/>
                                        <use xlink:href="#bubble" transform="translate(45, 83) scale(0.6)"/>
                                        <use xlink:href="#bubble" transform="translate(58, 60) scale(0.7)"/>
                                        <use xlink:href="#bubble" transform="translate(87, 95) scale(0.7)"/>
                                        <use xlink:href="#bubble" transform="translate(78, 110) scale(0.6)"/>
                                        <use xlink:href="#bubble" transform="translate(38, 105) scale(0.7)"/>
                                        <use xlink:href="#bubble" transform="translate(60, 110) scale(1.0)"/>
                                        <use xlink:href="#bubble" transform="translate(83, 64) scale(0.7)"/>
                                    </g>
                                    <path id="water"
                                          d="M1.4,6c0,0,9-9,18,0s18,0,18,0s9-9,18,0s18,0,18,0s9-9,18,0s18,0,18,0s9-9,18,0s18,0,18,0s9-9,18,0s18,0,18,0s9-9,18,0s18,0,18,0s9-9,18,0l0,100l-235,0z"
                                          fill="blue" stroke="none" opacity="0.7"/>
                                    <path id="laundry-1" transform="scale(0.07)"
                                          d="M366,269Q379,298,380,339.5Q381,381,352.5,412.5Q324,444,282,438Q240,432,212,403Q184,374,130.5,388.5Q77,403,86,351.5Q95,300,62,270Q29,240,29.5,196.5Q30,153,95,156.5Q160,160,179.5,150.5Q199,141,219.5,90Q240,39,280,42.5Q320,46,326,97Q332,148,383.5,153.5Q435,159,394,199.5Q353,240,366,269Z"/>
                                    <path id="laundry-2" transform="scale(0.07)"
                                          d="M345,261.5Q344,283,351,320.5Q358,358,330,374Q302,390,271,397Q240,404,211.5,391.5Q183,379,162,359Q141,339,122.5,317.5Q104,296,104.5,268Q105,240,84.5,203.5Q64,167,81,132.5Q98,98,127,67Q156,36,198,62Q240,88,285,55.5Q330,23,362.5,54Q395,85,374.5,139Q354,193,350,216.5Q346,240,345,261.5Z"/>
                                    <path id="laundry-3" transform="scale(0.07)"
                                          d="M425.5,284Q377,328,351,377Q325,426,276,379.5Q227,333,166,364.5Q105,396,65.5,349.5Q26,303,95,260.5Q164,218,170.5,192.5Q177,167,197,123.5Q217,80,244,126Q271,172,321.5,163.5Q372,155,423,197.5Q474,240,425.5,284Z"/>
                                    <g id="laundry">
                                        <use xlink:href="#laundry-1" transform="translate(10, 15)" fill="red"></use>
                                        <use xlink:href="#laundry-2" transform="translate(15, 30)" fill="blue"></use>
                                        <use xlink:href="#laundry-3" transform="translate(-8, 23)" fill="green"></use>
                                    </g>
                                </defs>
                                <rect x="10" y="10" width="100" height="120" rx="5" stroke="black" stroke-width="5"
                                      fill="white"/>
                                <line x1="10" y1="40" x2="110" y2="40" stroke="black" stroke-width="5"/>
                                <circle cx="60" cy="80" r="30" stroke="black" stroke-width="5" fill="lightblue"/>
                                <rect x="17" y="17" width="30" height="15" rx="2" stroke="black" stroke-width="2"
                                      fill="lightgrey"/>
                                <circle cx="60" cy="25" r="7" stroke="black" stroke-width="2" fill="darkgrey"/>
                                <rect x="75" y="20" width="30" height="10" rx="2" stroke="black" stroke-width="2"
                                      fill="green"/>
                                <path id="circlepath" d="M 60 50 A 30 30 0 1 1 59.9 50" stroke="blue" stroke-width="5"
                                      stroke-linecap="round"
                                      fill="none"/>
                                <g clip-path="url(#washer-window)">
                                    <g id="wiggle-bubbles">
                                        <g id="wash-bubbles">
                                            <use xlink:href="#bubbles"/>
                                            <use xlink:href="#bubbles" transform="translate(0, 60)"/>
                                        </g>
                                    </g>
                                    <g id="washing-water">
                                        <g id="flowing-water">
                                            <use xlink:href="#water" transform="translate(30,107), scale(2, 1)"/>
                                        </g>
                                    </g>

                                </g>
                                <g id="washing-laundry" transform="rotate(180),translate(0,0)">
                                    <use xlink:href="#laundry" transform="translate(0,0)"></use>
                                </g>
                                <text id="countdown-{{ $washer->id }}" x="60" y="83"
                                      text-anchor="middle">{{ $washer->state == 'stop' ? 'Finished' : ' Loading' }}</text>

                            </svg>
                        </div>
                    </div>
                </div>
                @if($washer->state != 'stop')
                    <script>
                        (function () {
                            let endTime = new Date('{{$washer->end->toISOString()}}').getTime();
                            let el = document.getElementById('countdown-{{ $washer->id }}');
                            let x = setInterval(_ => {
                                let now = new Date().getTime();
                                let t = endTime - now;
                                let hours = Math.floor((t % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                let minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
                                let seconds = Math.floor((t % (1000 * 60)) / 1000);
                                let hourString = hours > 0 ? hours + ':' : '';
                                let minuteString = (hours > 0 ? minutes.toString().padStart(2, '0') : minutes) + ':';
                                let secondString = seconds.toString().padStart(2, '0')
                                el.innerHTML = hourString + minuteString + secondString;
                                if (t < 0) {
                                    clearInterval(x);
                                    el.innerHTML = 'Finished';
                                }

                            }, 1000);
                        })();
                    </script>
                @endif
            @endforeach
        </div>
    </div>
@endsection
