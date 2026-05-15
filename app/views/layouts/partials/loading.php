<link rel="stylesheet" href="/css/animation/loading.css">

<div id="loadingScreen" 
    style="transition: opacity 0.5s ease-out;"
    class="flex-col items-center justify-center fixed top-0 left-0 right-0 bottom-0 w-full h-full z-[9999] bg-white flex">
    <div class="flex flex-col items-center gap-8">
        <div class="relative w-20 h-20">
            <div class="absolute inset-0 rounded-full border-4 border-transparent border-t-[#FFCD56]" style="animation: spin 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;"></div>
            <div class="absolute inset-0 rounded-full border-4 border-transparent border-r-[#1D7BC5]" style="animation: spin 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite; animation-delay: -0.3s;"></div>
            <div class="absolute inset-0 rounded-full border-4 border-transparent border-l-[#FF4040]" style="animation: spin 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;"></div>
        </div>

        <div class="flex gap-1" id="textWave">
            <span class="text-[#545F71] text-2xl font-bold inline-block">I</span>
            <span class="text-[#545F71] text-2xl font-bold inline-block">m</span>
            <span class="text-[#545F71] text-2xl font-bold inline-block">m</span>
            <span class="text-[#545F71] text-2xl font-bold inline-block">a</span>
            <span class="text-[#545F71] text-2xl font-bold inline-block">S</span>
            <span class="text-[#545F71] text-2xl font-bold inline-block">p</span>
            <span class="text-[#545F71] text-2xl font-bold inline-block">a</span>
            <span class="text-[#545F71] text-2xl font-bold inline-block">r</span>
            <span class="text-[#545F71] text-2xl font-bold inline-block">k</span>
        </div>
    </div>
</div>

<script src="/js/animation/loading.js"></script>