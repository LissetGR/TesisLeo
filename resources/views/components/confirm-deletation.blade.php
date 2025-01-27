@props(['elemento', 'data'])

<x-modal name="confirm-deletion"  :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route($elemento . '.destroy', $data) }}"   class="p-6">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('¿Estas seguro que deseas eliminar este elemento?') }}
        </h2>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3">
                {{ __('Delete') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
