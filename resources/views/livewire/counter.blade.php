<div>
    {{-- Be like water. --}}
    <div style="text-align: center">
        <button wire:click.prevent="increment">+</button>
        <div>
            <div style="position: absolute;width: 30px; height: 30px;background: rebeccapurple;opacity: 0.5;left: 113px;" wire:loading.delay>..</div>  
            <div style="width: 30px; height: 30px;background: rebeccapurple;opacity: 0.;" wire:loading.class="bg-dark">{{ $count }}</div>
        </div>
        <button wire:click="decrement">-</button>
        
        
        {{-- <div wire:loading wire:target="increment">
            
            Processing ......
            
        </div> --}}
    </div>

    {{-- {{ $lo }} --}}
</div>
