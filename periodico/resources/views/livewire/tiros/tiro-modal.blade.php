<div>
   
    <div wire:click="showModal" wire:loading.attr="disabled" class="p-4 text-gray-900 cursor-pointer"> 
        Open modal
    </div>

    <x-jet-dialog-modal wire:model="showingModal" >
        
        <x-slot name="title">
            
        </x-slot>


        <x-slot name="content">

           <h1>helo world</h1>

        </x-slot>


        <x-slot name="footer">
            {{-- <x-jet-secondary-button wire:click="$set('showingModal', false)" wire:loading.attr="disabled">
                {{ __('Cancel')  }}
             </x-jet-secondary-button> --}}
        </x-slot>

    </x-jet-dialog-modal>

    

</div>