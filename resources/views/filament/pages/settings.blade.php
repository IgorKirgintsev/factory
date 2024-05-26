<x-filament-panels::page>
    <x-filament-panels::form>
        {{$this->form}}

        <div class="flex-auto flex space-x-4">
            <x-filament::button size="lg" color="success" wire:click="getReport">
            Формировать отчет
          </x-filament::button>
        </div>


<!--       <x-filament-panels::form.actions ://action="$this->getFormActions()"/>  -->
     </form>
    </x-filament-panels::form>
</x-filament-panels::page>
