<php>
    $true = 1;
</php>
<div role="map-route" class="flex w-full sm:w-auto">
    <template p-if="$true">
        <a class="text-2xl font-serif font-semibold text-purple-900" href=""><i class="fas fa-book"></i><span class="text-lg text-blue-700"></span></a>
        <span p-if="$true" class="self-end text-sm font-semibold text-purple-800">, capitolul</span>
        <a p-else href="/" class="inline text-lg font-serif font-semibold text-purple-900"><i class="fas fa-home"></i> Home</a>
    </template>
</div>
=====
<div role="map-route" class="flex w-full sm:w-auto">
    <a class="text-2xl font-serif font-semibold text-purple-900" href=""><i class="fas fa-book"></i><span class="text-lg text-blue-700"></span></a>
    <span  class="self-end text-sm font-semibold text-purple-800">, capitolul</span>
</div>