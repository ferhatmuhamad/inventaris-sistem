<?php

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Request;

?>

<div class="text-center">
    {{-- {!! QrCode::size(100)->generate(Request::url()); !!} --}}
    {{ QrCode::size(100)->generate('oke') }}
    <p>Scan me to return to the original page.</p>

    {{-- //Inside of a blade template. --}}
</div>