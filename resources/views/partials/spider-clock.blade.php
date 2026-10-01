@php
    // The spider hangs upside down on its silk thread: abdomen = clock, head at the bottom.
    // Left legs: [base, knee, ankle, foot tip, sway direction]. Right legs are mirrored (x -> 200 - x).
    $legs = [
        [[86, 262], [50, 270], [38, 296], [30, 322], 4],
        [[78, 256], [34, 266], [16, 290], [6, 314], -4],
        [[76, 246], [34, 236], [12, 214], [4, 192], 5],
        [[80, 238], [42, 214], [24, 186], [14, 158], -5],
    ];
    $widths = [4.6, 3.2, 1.7]; // thick thigh, thin foot tip
    $mirror = fn ($p, $m) => [$m ? 200 - $p[0] : $p[0], $p[1]];
@endphp
<div class="spider" aria-hidden="true">
<div class="spider-lean">
    <svg class="spider-svg" viewBox="0 0 200 330" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <radialGradient id="sp-abdomen" cx="38%" cy="28%" r="80%">
                <stop offset="0" stop-color="#4a4a4a"/>
                <stop offset=".55" stop-color="#151515"/>
                <stop offset="1" stop-color="#000"/>
            </radialGradient>
            <radialGradient id="sp-thorax" cx="40%" cy="30%" r="80%">
                <stop offset="0" stop-color="#3c3c3c"/>
                <stop offset=".6" stop-color="#101010"/>
                <stop offset="1" stop-color="#000"/>
            </radialGradient>
            <radialGradient id="sp-face" cx="50%" cy="50%" r="50%">
                <stop offset="0" stop-color="#111"/>
                <stop offset="1" stop-color="#000"/>
            </radialGradient>
        </defs>

        <line class="spider-thread" id="spider-thread" x1="100" y1="0" x2="100" y2="84"/>

        <g class="spider-rig" id="spider-rig">

        {{-- Legs: 3 segments (thigh, shin, foot) with fine hairs and joints at the knees --}}
        <g class="spider-legs">
            @foreach ($legs as $i => $leg)
                @foreach ([false, true] as $m)
                    @php
                        $pts = array_map(fn ($p) => $mirror($p, $m), array_slice($leg, 0, 4));
                        $r = $leg[4] * ($m ? -1 : 1);
                        $d = $i * .35 + ($m ? .17 : 0);
                    @endphp
                    <g class="leg-reach" data-side="{{ $m ? 'r' : 'l' }}" data-w="{{ [.5, .7, 1, 1][$i] }}" data-ax="{{ $pts[0][0] }}" data-ay="{{ $pts[0][1] }}" data-fx="{{ $pts[3][0] }}" data-fy="{{ $pts[3][1] }}">
                    <g class="leg" style="transform-origin:{{ $pts[0][0] }}px {{ $pts[0][1] }}px;--r:{{ $r }}deg;--d:{{ $d }}s">
                        @for ($s = 0; $s < 3; $s++)
                            @php
                                [$a, $b] = [$pts[$s], $pts[$s + 1]];
                            @endphp
                            <line class="sp-seg" x1="{{ $a[0] }}" y1="{{ $a[1] }}" x2="{{ $b[0] }}" y2="{{ $b[1] }}" stroke-width="{{ $widths[$s] }}"/>
                            @if ($s < 2)
                                @php
                                    $dx = $b[0] - $a[0]; $dy = $b[1] - $a[1];
                                    $len = max(sqrt($dx * $dx + $dy * $dy), 1);
                                    $nx = -$dy / $len; $ny = $dx / $len;
                                @endphp
                                @foreach ([.25, .5, .75] as $k => $t)
                                    @php
                                        $px = $a[0] + $dx * $t; $py = $a[1] + $dy * $t;
                                        $sg = $k % 2 ? 1 : -1; $hl = 3.4 + $widths[$s] / 2;
                                    @endphp
                                    <line class="sp-hair" x1="{{ round($px, 1) }}" y1="{{ round($py, 1) }}" x2="{{ round($px + $nx * $hl * $sg, 1) }}" y2="{{ round($py + $ny * $hl * $sg, 1) }}"/>
                                @endforeach
                            @endif
                        @endfor
                        <circle class="sp-joint" cx="{{ $pts[1][0] }}" cy="{{ $pts[1][1] }}" r="2.7"/>
                        <circle class="sp-joint" cx="{{ $pts[2][0] }}" cy="{{ $pts[2][1] }}" r="1.9"/>
                    </g>
                    </g>
                @endforeach
            @endforeach
        </g>

        {{-- Abdomen: dark sphere with a clock bezel --}}
        <path class="sp-body" fill="url(#sp-abdomen)" d="M100 84C136 84 158 112 158 150C158 190 134 216 100 216C66 216 42 190 42 150C42 112 64 84 100 84Z"/>
        @for ($i = 0; $i < 24; $i++)
            @php
                $an = deg2rad($i * 15);
                $cx = 100 + sin($an) * 50; $cy = 150 - cos($an) * 58;
                $ex = 100 + sin($an) * 54; $ey = 150 - cos($an) * 62;
            @endphp
            <line class="sp-hair" x1="{{ round($cx, 1) }}" y1="{{ round($cy, 1) }}" x2="{{ round($ex, 1) }}" y2="{{ round($ey, 1) }}"/>
        @endfor
        {{-- Spinneret where the thread comes out --}}
        <path class="sp-body" fill="var(--black)" d="M96 86Q100 78 104 86Z"/>

        {{-- Narrow waist (pedicel) --}}
        <path class="sp-body" fill="var(--black)" d="M94 214Q100 236 106 214Z"/>

        {{-- Head: rotates to face the cursor (handled by app.js) --}}
        <g id="spider-head">
        {{-- Pedipalps (a pair of short legs near the mouth) --}}
        <polyline class="sp-seg" stroke-width="3" points="90,268 83,282 88,294"/>
        <polyline class="sp-seg" stroke-width="3" points="110,268 117,282 112,294"/>

        <path class="sp-body" fill="url(#sp-thorax)" d="M100 228C122 228 128 246 126 260C124 272 114 278 100 278C86 278 76 272 74 260C72 246 78 228 100 228Z"/>
        <path class="sp-hair" style="opacity:.7" d="M100 238V250M96 244L100 250L104 244"/>

        {{-- Eight eyes --}}
        <g class="spider-eyes" id="spider-eyes">
            <circle class="spider-eye" cx="90" cy="266" r="1.7"/>
            <circle class="spider-eye" cx="96" cy="264" r="1.7"/>
            <circle class="spider-eye" cx="104" cy="264" r="1.7"/>
            <circle class="spider-eye" cx="110" cy="266" r="1.7"/>
            <circle class="spider-eye" cx="93" cy="257" r="2.6"/>
            <circle class="spider-eye" cx="107" cy="257" r="2.6"/>
            <circle class="spider-eye" cx="89" cy="250" r="1.5"/>
            <circle class="spider-eye" cx="111" cy="250" r="1.5"/>
            <g id="spider-pupils">
                <circle class="spider-pupil" cx="93" cy="257" r="1.3"/>
                <circle class="spider-pupil" cx="107" cy="257" r="1.3"/>
            </g>
        </g>

        {{-- Fangs (chelicerae) --}}
        <path class="sp-fang fang-l" d="M93 275Q90 288 96 296Q97 286 98 277Z"/>
        <path class="sp-fang fang-r" d="M107 275Q110 288 104 296Q103 286 102 277Z"/>

        </g>

        {{-- Clock on the abdomen --}}
        <circle class="clock-face" cx="100" cy="150" r="42"/>
        <circle class="clock-rim" cx="100" cy="150" r="42"/>
        <circle class="clock-rim inner" cx="100" cy="150" r="38.5"/>
        @for ($i = 0; $i < 60; $i++)
            @php $hr = $i % 5 === 0; @endphp
            <line class="clock-tick{{ $hr ? ' major' : '' }}" x1="100" y1="{{ $hr ? 112 : 112 }}" x2="100" y2="{{ $hr ? 121 : 115 }}" transform="rotate({{ $i * 6 }} 100 150)"/>
        @endfor
        <line class="hand" id="hand-h" x1="100" y1="150" x2="100" y2="127"/>
        <line class="hand" id="hand-m" x1="100" y1="150" x2="100" y2="117"/>
        <line class="hand" id="hand-s" x1="100" y1="160" x2="100" y2="113"/>
        <circle class="clock-pin" cx="100" cy="150" r="3"/>
        <path class="glass" d="M70 128Q82 108 108 110Q84 116 74 138Z"/>
        </g>
    </svg>
</div>
</div>
