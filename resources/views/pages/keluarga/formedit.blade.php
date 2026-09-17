 {{-- P3-P502 --}}
                                        <div class="btn-group" role="group"
                                            aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-secondary dropdown-toggle btn-sm"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                    P3-P502
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/set-session/' . $d->id . '/p3') }}"
                                                        data-id="{{ $d->id }}"
                                                        data-id_survey="{{ $d->id_survey }}">P3
                                                        @if (\App\Models\Desa\P3\P3::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p3Pegawai') }}">
                                                        Pegawai
                                                        @if (
                                                            \App\Models\Desa\P3\PegawaiLainnya::whereHas('p3', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p3Bpd') }}">
                                                        BPD
                                                        @if (
                                                            \App\Models\Desa\P3\AnggotaBpd::whereHas('p3', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/set-session/' . $d->id . '/p4') }}">P4
                                                        @if (\App\Models\Desa\P4\P4::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/set-session/' . $d->id . '/p5') }}"
                                                        data-id="{{ $d->id }}"
                                                        data-id_survey="{{ $d->id_survey }}">P5
                                                        @if (\App\Models\Desa\P5\P5::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p501') }}">
                                                        Peraturan Desa
                                                        @if (
                                                            \App\Models\Desa\P5\P501::whereHas('p5', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p502') }}">
                                                        Peraturan KepDes
                                                        @if (
                                                            \App\Models\Desa\P5\P502::whereHas('p5', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- P503-P8 --}}
                                        <div class="btn-group" role="group"
                                            aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-secondary dropdown-toggle btn-sm"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                    P503-P8
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p503') }}">
                                                        SK KepDes
                                                        @if (
                                                            \App\Models\Desa\P5\P503::whereHas('p5', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/set-session/' . $d->id . '/p601') }}"
                                                        data-id="{{ $d->id }}"
                                                        data-id_survey="{{ $d->id_survey }}">P601
                                                        @if (\App\Models\Desa\P6\P601::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/set-session/' . $d->id . '/p602') }}"
                                                        data-id="{{ $d->id }}"
                                                        data-id_survey="{{ $d->id_survey }}">P602
                                                        @if (\App\Models\Desa\P6\P602::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/set-session/' . $d->id . '/p603') }}"
                                                        data-id="{{ $d->id }}"
                                                        data-id_survey="{{ $d->id_survey }}">P603
                                                        @if (\App\Models\Desa\P6\P603::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/set-session/' . $d->id . '/p7') }}"
                                                        data-id="{{ $d->id }}"
                                                        data-id_survey="{{ $d->id_survey }}">P7
                                                        @if (\App\Models\Desa\P7\P7::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p705') }}">
                                                        P705
                                                        @if (
                                                            \App\Models\Desa\P7\P705::whereHas('p7', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/set-session/' . $d->id . '/p8') }}"
                                                        data-id="{{ $d->id }}"
                                                        data-id_survey="{{ $d->id_survey }}">P8
                                                        @if (\App\Models\Desa\P8\P8::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- P9-P10 --}}
                                        <div class="btn-group" role="group"
                                            aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-secondary dropdown-toggle btn-sm"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                    P9-P10
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/set-session/' . $d->id . '/p9') }}"
                                                        data-id="{{ $d->id }}"
                                                        data-id_survey="{{ $d->id_survey }}">P9
                                                        @if (\App\Models\Desa\P9\P9::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p914') }}">
                                                        P914
                                                        @if (
                                                            \App\Models\Desa\P9\P914::whereHas('p9', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p923') }}">
                                                        P923
                                                        @if (
                                                            \App\Models\Desa\P9\P923::whereHas('p9', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p932') }}">
                                                        P932
                                                        @if (
                                                            \App\Models\Desa\P9\P932::whereHas('p9', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/desa-p2/' . $d->id_survey . '/p941') }}">
                                                        P941
                                                        @if (
                                                            \App\Models\Desa\P9\P941::whereHas('p9', function ($q) use ($d) {
                                                                $q->where('id_survey', $d->id_survey);
                                                            })->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                    <a class="dropdown-item" style="display: flex; justify-content: space-between"
                                                        href="{{ url('/set-session/' . $d->id . '/p10') }}"
                                                        data-id="{{ $d->id }}"
                                                        data-id_survey="{{ $d->id_survey }}">P10
                                                        @if (\App\Models\Desa\P10\P10::where('id_survey', $d->id_survey)->exists())
                                                            <i class="fas fa-check text-success ml-2"></i>
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                        </div>