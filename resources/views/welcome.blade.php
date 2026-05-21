@extends('layouts.main')

@section('content')


<section class="bg-coffee-100 py-24 border-b border-coffee-200">
    <div class="container mx-auto px-6 max-w-5xl">
        
        <div class="text-center mb-16">
            <span class="text-xs font-bold uppercase tracking-widest text-amber-600 block mb-3">Our Philosophy</span>
            <h2 class="text-3xl md:text-4xl font-black text-coffee-800 tracking-tight">
                Welcome to Simeon Brewers
            </h2>
            <div class="w-16 h-1 bg-amber-500 mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            
            <div class="bg-white p-8 md:p-10 rounded-2xl border border-coffee-200 shadow-sm">
                <div class="bg-amber-500/10 w-12 h-12 rounded-xl flex items-center justify-center mb-6 text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3 class="text-xl font-bold text-coffee-900 mb-3">Crafted with Passion</h3>
                <p class="text-gray-600 text-sm md:text-base leading-relaxed">
                    Enjoy premium coffee, freshly brewed and served with unyielding passion. Every blend we execute is tailored toward bringing out the complex flavor profiles inherent to the beans.
                </p>
            </div>

            <div class="space-y-6">
                <div class="flex gap-4">
                    <div class="shrink-0 text-amber-600 font-bold text-lg mt-0.5">✓</div>
                    <div>
                        <h4 class="font-bold text-coffee-900 text-base mb-1">Small Batch Precision</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">We roast purposefully in monitored settings to control quality density across all extractions.</p>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <div class="shrink-0 text-amber-600 font-bold text-lg mt-0.5">✓</div>
                    <div>
                        <h4 class="font-bold text-coffee-900 text-base mb-1">Sustainably Farm Sourced</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Cultivating absolute relationships with regional farmers who care about ethical coffee growing methods.</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

@endsection