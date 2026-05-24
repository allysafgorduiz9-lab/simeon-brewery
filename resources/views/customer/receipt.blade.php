@extends('layouts.main')

@section('content')
<div class="bg-stone-100 min-h-screen py-12 flex flex-col items-center justify-center px-4">
    
    <div id="receipt-card" class="bg-white rounded-3xl border border-stone-200 shadow-xl max-w-md w-full overflow-hidden relative">
        
        <div class="bg-gradient-to-br from-coffee-800 to-coffee-900 text-white text-center pt-10 pb-12 px-6 relative">
            <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-md ring-4 ring-white/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="text-2xl font-black tracking-tight">Order Confirmed!</h1>
            <p class="text-coffee-300 text-xs mt-1 font-medium">Thank you for brewing with Simeon Brewers</p>
            
            <div class="absolute bottom-0 left-0 right-0 h-2 bg-white matching-cut"></div>
        </div>

        <div class="p-8 pt-10 space-y-6 relative bg-white">
            
            <div class="text-center border-b border-dashed border-stone-200 pb-6">
                <span class="text-xs text-stone-400 font-bold uppercase tracking-wider block mb-1">Amount Paid / Due</span>
                <span class="text-4xl font-black text-coffee-900 tracking-tight">₱{{ number_format($total, 2) }}</span>
            </div>

            <div class="space-y-3.5 text-sm">
                <div class="flex justify-between items-center">
                    <span class="text-stone-400 font-medium">Receipt Reference</span>
                    <span class="font-mono font-bold text-stone-800 bg-stone-100 px-2 py-0.5 rounded text-xs tracking-wider">
                        {{ $receiptId }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-stone-400 font-medium">Customer Name</span>
                    <span class="font-bold text-coffee-900">{{ $name }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-stone-400 font-medium">Payment Option</span>
                    <span class="font-bold text-coffee-900 flex items-center gap-1.5">
                        @if(strtolower($method) == 'gcash')
                            <span class="w-2 h-2 rounded-full bg-blue-500 inline-block"></span>
                        @elseif(strtolower($method) == 'paymaya')
                            <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>
                        @else
                            <span class="w-2 h-2 rounded-full bg-amber-500 inline-block"></span>
                        @endif
                        {{ $method }}
                    </span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-stone-400 font-medium">Issued Timestamp</span>
                    <span class="font-medium text-stone-700 text-xs">
    {{ \Carbon\Carbon::now('Asia/Manila')->format('M d, Y • h:i A') }}
</span>
                </div>
            </div>

            <div class="bg-amber-50/50 border border-amber-200/60 rounded-xl p-3.5 text-center mt-4">
                <p class="text-xs text-amber-800 font-medium leading-relaxed">
                    Please present this downloaded voucher image screen directly to our barista counter crew as ownership verification.
                </p>
            </div>
            
            <div class="pt-4 flex flex-col items-center justify-center opacity-25 select-none">
                <div class="w-40 h-6 bg-[repeating-linear-gradient(90deg,transparent,transparent_2px,#000_2px,#000_6px)]"></div>
                <span class="text-[9px] font-mono tracking-widest text-black mt-1">SIMEONBREWSPH</span>
            </div>
        </div>
    </div>

    <div class="max-w-md w-full mt-6 space-y-3 px-2">
        <button type="button" onclick="downloadReceipt()" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3.5 px-4 rounded-xl text-sm transition-all shadow-md active:scale-[0.99] flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Save Receipt to Gallery
        </button>

        <a href="/" class="block text-center w-full bg-stone-200 hover:bg-stone-300 text-stone-700 font-bold py-3 px-4 rounded-xl text-sm transition tracking-wide">
            Return to Store Home
        </a>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
function downloadReceipt() {
    const targetElement = document.getElementById("receipt-card");
    
    // Smooth high-res image renders matching clean device ratios
    html2canvas(targetElement, {
        scale: 3, // Upscales crispness resolution so text remains pin-sharp on modern displays
        backgroundColor: "#ffffff",
        logging: false,
        useCORS: true
    }).then(canvas => {
        // Transform canvas element into raw downloadable data stream
        const imageData = canvas.toDataURL("image/png");
        
        // Construct a virtual click pipeline to save the image file instantly
        const downloadLink = document.createElement("a");
        downloadLink.href = imageData;
        downloadLink.download = "SimeonBrewers_Receipt_{{ $receiptId }}.png";
        
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    });
}
</script>

<style>
.matching-cut {
    background-image: linear-gradient(-45deg, #fff 4px, transparent 0), linear-gradient(45deg, #fff 4px, transparent 0);
    background-position: left bottom;
    background-size: 8px 8px;
    background-repeat: repeat-x;
}
</style>
@endsection