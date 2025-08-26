<div class="space-y-4">
    <div class="flex justify-between gap-4">
        <flux:select label="Sort by">
            <flux:select.option>Select Sort By</flux:select.option>
            <flux:select.option>Due date</flux:select.option>
            <flux:select.option>Priority</flux:select.option>
            <flux:select.option>Status</flux:select.option>
        </flux:select>
        <flux:modal.trigger name="create-todolist">
            <flux:button>
                Create New
            </flux:button>
        </flux:modal.trigger>
    </div>
    <div>
        <flux:modal name="create-todolist" class="max-w-[90%] w-full sm:max-w-lg" :dismissible="false">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">New To-Do List</flux:heading>
                    <flux:text>Add a task or idea.</flux:text>
                </div>
                @if(session('todolistCreated'))
                    <template x-data="{ close: false }" x-if="!close">
                        <div
                            class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                            role="alert">
                            <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <div class="ms-3 text-xs sm:text-sm font-medium">
                                {{ session('todolistCreated') }}
                            </div>
                            <button type="button"
                                    class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                                    @click="close = true">
                                <span class="sr-only">Close</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            </button>
                        </div>
                    </template>
                @endif
                <form class="space-y-4" action="#" wire:submit.prevent="createTodolist" autocomplete="off">
                    <div class="space-y-3">
                        <flux:field>
                            <flux:label>Title</flux:label>
                            <flux:input wire:model="todolistForm.title" type="text" placeholder="Enter todolist title"/>
                            <flux:error name="todolistForm.title" class="-mt-1!"/>
                        </flux:field>
                        <flux:field>
                            <flux:label>Due Date</flux:label>
                            <flux:input type="date" wire:model="todolistForm.dueDate"/>
                            <flux:error name="todolistForm.dueDate" class="-mt-1!"/>
                        </flux:field>
                        <flux:field>
                            <flux:label>Priority</flux:label>
                            <flux:select wire:model="todolistForm.priority">
                                <flux:select.option value="">Select Priority</flux:select.option>
                                @foreach(\App\Models\TodolistPriority::get() as $priority)
                                    <flux:select.option
                                        value="{{ $priority->id }}">{{ $priority->name }}</flux:select.option>
                                @endforeach
                            </flux:select>
                            <flux:error name="todolistForm.priority" class="-mt-1!"/>
                        </flux:field>
                        <flux:textarea label="Description" wire:model="todolistForm.description"
                                       placeholder="Enter todolist description"/>
                    </div>
                    <div class="justify-self-end flex gap-3">
                        <flux:modal.close>
                            <flux:button>Cancel</flux:button>
                        </flux:modal.close>
                        <flux:button type="submit" variant="primary">Create</flux:button>
                    </div>
                </form>
            </div>
        </flux:modal>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        @foreach($this->todolists as $todolist)
            <x-todolist-card :$todolist/>
        @endforeach
    </div>
</div>
