@props(['internship' => null, 'isCreateRoute' => false])
@php
    use Carbon\Carbon;
@endphp
<div wire:key="internship-card-{{ $internship->id }}" wire:poll.3s>
    <flux:modal.trigger name="internship-{{ $internship->id }}" wire:key="trigger-{{ $internship->id }}">
        <div
            class="p-6 block rounded-lg shadow outline outline-gray-100 dark:outline-gray-500 hover:outline-blue-500 transition-colors duration-300 cursor-pointer dark:shadow-none overflow-hidden bg-white/30 backdrop-blur-md dark:bg-gray-900/30 h-full">
            <div class="flex flex-col justify-between h-full space-y-2">
                <div class="space-y-1">
                    @if($isCreateRoute)
                        <div class="flex items-center justify-between">
                            <div>
                                @php($statusLabel = optional($internship->status)->status)
                                @php($isInactive = in_array(strtolower($statusLabel ?? ''), ['deleted','banned']))
                                @switch($statusLabel)
                                    @case('Pending')
                                        <flux:badge color="zinc">Pending</flux:badge>
                                        @break
                                    @case('Approved')
                                        <flux:badge color="green">Approved</flux:badge>
                                        @break
                                    @case('Rejected')
                                        <flux:badge color="red">Rejected</flux:badge>
                                        @break
                                    @default
                                        @if($statusLabel)
                                            <flux:badge color="zinc">{{ $statusLabel }}</flux:badge>
                                        @endif
                                @endswitch
                            </div>
                            <div class="flex items-center space-x-2 sm:ml-auto w-fit order-2">
                                <div class="flex items-center space-x-1">
                                    <flux:icon.academic-cap variant="solid" class="text-blue-500"/>
                                    <flux:text>{{ $internship->vocationalMajor->major_name }}</flux:text>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <flux:icon.heart variant="solid" class="text-red-500"/>
                                    <flux:text>{{ $internship->likes_count }}</flux:text>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="flex items-start gap-3">
                        @if($internship->company_logo)
                            <img src="{{ asset('storage/' . $internship->company_logo) }}" alt="{{ $internship->company }} Logo" class="h-12 w-12 object-contain rounded border flex-shrink-0"/>
                        @endif
                        <div>
                            <h1 class="text-lg md:text-xl font-medium">{{ $internship->job_title }}</h1>
                            <h2 class="md:text-lg">{{ $internship->company }}</h2>
                        </div>
                    </div>
                    <p class="text-sm md:text-base">{{ $internship->location }}</p>
                    <div class="flex sm:block justify-between items-center space-y-1">
                        @if(!$isCreateRoute)
                            <div class="flex items-center space-x-2 sm:ml-auto w-fit order-2">
                                <div class="flex items-center space-x-1">
                                    <flux:icon.academic-cap variant="solid" class="text-blue-500"/>
                                    <flux:text>{{ $internship->vocationalMajor->major_name }}</flux:text>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <flux:icon.heart variant="solid" class="text-red-500"/>
                                    <flux:text>{{ $internship->likes_count }}</flux:text>
                                </div>
                            </div>
                        @endif
                        <div class="sm:flex items-center justify-between sm:space-x-2">
                            <flux:text>Posted {{ $internship->created_at->diffForHumans() }}</flux:text>
                            <flux:text>Closes
                                on {{ Carbon::parse($internship->end_date)->format("D, d M Y") }}</flux:text>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </flux:modal.trigger>

    <flux:modal name="internship-{{ $internship->id }}" class="max-w-[90%] w-full sm:max-w-lg outline-none"
                wire:key="modal-{{ $internship->id }}"
                :dismissible="false">
        <div class="space-y-3">
            <div>
                <flux:heading class="text-xl">Internship Details</flux:heading>
            </div>
            <flux:separator/>
            <div>
                <div class="flex items-start gap-3 mb-2">
                    @if($internship->company_logo)
                        <img src="{{ asset('storage/' . $internship->company_logo) }}" alt="{{ $internship->company }} Logo" class="h-16 w-16 object-contain rounded border flex-shrink-0"/>
                    @endif
                    <div>
                        <h1 class="text-base md:text-lg">
                            {{ $internship->job_title }}
                        </h1>
                        <flux:text class="text-base md:text-lg">
                            {{ $internship->company }}
                        </flux:text>
                    </div>
                </div>
                <div class="space-y-1">
                    <div class="flex items-center space-x-2 place-items-center">
                        <flux:icon.map-pin variant="solid" class="text-red-500"/>
                        <flux:text>{{ $internship->location }}</flux:text>
                    </div>
                    <div class="flex items-center space-x-2 place-items-center">
                        <flux:icon.academic-cap variant="solid" class="text-blue-500"/>
                        <flux:text>{{ $internship->vocationalMajor->major_name }}</flux:text>
                    </div>
                    <div class="flex items-center space-x-2 place-items-center">
                        <flux:icon.phone variant="solid" class="text-green-500"/>
                        <flux:text>{{ "$internship->contact_phone ($internship->contact_name)" }}</flux:text>
                    </div>
                    @if($internship->contact_email)
                        <div class="flex items-center space-x-2 place-items-center">
                            <flux:icon.envelope variant="solid" class="text-shadow-slate-400"/>
                            <flux:text>{{ "$internship->contact_email" }}</flux:text>
                        </div>
                    @endif
                    <div class="flex items-center space-x-2 place-items-center">
                        <flux:icon.heart variant="solid" class="text-red-500"/>
                        <flux:text>{{ $internship->likes_count }} People like this post</flux:text>
                    </div>
                    <div class="flex items-center space-x-2 place-items-center">
                        <flux:icon.calendar-days variant="solid"/>
                        <flux:text>Until {{ Carbon::parse($internship->end_date)->format("l, d M Y") }} </flux:text>
                    </div>
                </div>
            </div>
            <div class="flex gap-x-4 gap-y-2 flex-wrap">
                @if($internship->bookmarked_by_me)
                    <flux:tooltip content="Unsave this post">
                        <flux:button variant="primary" icon="bookmark" icon:variant="solid"
                                     wire:click.stop="toggleBookmark('{{ $internship->getKey() }}')"
                                     wire:loading.class="pointer-events-none animate-pulse"
                                     wire:target="toggleBookmark"/>
                    </flux:tooltip>
                @else
                    <flux:tooltip content="Save this post">
                        <flux:button variant="primary" icon="bookmark" icon:variant="outline"
                                     wire:click.stop="toggleBookmark('{{ $internship->getKey() }}')"
                                     wire:loading.class="pointer-events-none animate-pulse"
                                     wire:target="toggleBookmark"/>
                    </flux:tooltip>
                @endif
                @if($internship->liked_by_me)
                    <flux:tooltip content="Remove like">
                        <flux:button icon="heart" variant="primary" color="red" icon:variant="solid"
                                     class="hidden md:flex" wire:click.stop="toggleLike('{{ $internship->getKey() }}')"
                                     wire:loading.class="pointer-events-none animate-pulse"
                                     wire:target="toggleLike"/>
                    </flux:tooltip>
                @else
                    <flux:tooltip content="Like this post">
                        <flux:button icon="heart" variant="primary" color="red" icon:variant="outline"
                                     wire:click.stop="toggleLike('{{ $internship->getKey() }}')"
                                     wire:loading.class="pointer-events-none animate-pulse" wire:target="toggleLike"/>
                    </flux:tooltip>
                @endif
                @if($isCreateRoute && !$isInactive)
                    <flux:modal.trigger name="edit-internship-{{ $internship->id }}">
                        <flux:tooltip content="Edit this post">
                            <flux:button icon="pencil-square" variant="primary" color="blue" icon:variant="outline"
                                         wire:click="loadForEdit('{{ $internship->getKey() }}')"/>
                        </flux:tooltip>
                    </flux:modal.trigger>
                    <flux:modal.trigger name="delete-internship-{{ $internship->id }}">
                        <flux:tooltip content="Delete this post">
                            <flux:button icon="trash" variant="primary" color="red" icon:variant="outline"/>
                        </flux:tooltip>
                    </flux:modal.trigger>
                @endif
            </div>
            <div class="space-y-2 [&_div]:space-y-1">
                <div>
                    <flux:heading size="lg">Job Description</flux:heading>
                    <flux:text>
                        {{ $internship->job_description }}
                    </flux:text>
                </div>
                <div>
                    <flux:heading size="lg">Requirements</flux:heading>
                    <flux:text>
                        {{ $internship->requirements }}
                    </flux:text>
                </div>
                @if($internship->benefits)
                    <div>
                        <flux:heading size="lg">Benefits</flux:heading>
                        <flux:text>
                            {{ $internship->benefits }}
                        </flux:text>
                    </div>
                @endif
            </div>
            <flux:separator class="my-4"/>
            <livewire:internships.comments :internship="$internship" :key="'comments-'.$internship->id" />
        </div>
    </flux:modal>
    @if($isCreateRoute && !$isInactive)
        <flux:modal class="max-w-[90%] w-full sm:max-w-2xl outline-none" name="edit-internship-{{ $internship->id }}"
                    :dismissible="true" wire:ignore.self>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <flux:heading class="text-xl">Edit Internship</flux:heading>
                </div>
                <flux:separator/>
                <form class="space-y-4" wire:submit.prevent="updatePost('{{ $internship->getKey() }}')">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <flux:field>
                                <flux:label>Job Title</flux:label>
                                <flux:input wire:model.defer="internshipForm.job_title" placeholder="Job title"/>
                                @error('internshipForm.job_title') <p
                                    class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </flux:field>
                        </div>
                        <div>
                            <flux:field>
                                <flux:label>Company</flux:label>
                                <flux:input wire:model.defer="internshipForm.company" placeholder="Company"/>
                                @error('internshipForm.company') <p
                                    class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </flux:field>
                        </div>
                        <div>
                            <flux:field>
                                <flux:label>Location</flux:label>
                                <flux:input wire:model.defer="internshipForm.location" placeholder="Location"/>
                                @error('internshipForm.location') <p
                                    class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </flux:field>
                        </div>
                        <div>
                            <flux:field>
                                <flux:label>Close Date</flux:label>
                                <flux:input type="date" wire:model.defer="internshipForm.end_date"/>
                                @error('internshipForm.end_date') <p
                                    class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </flux:field>
                        </div>
                        <div class="md:col-span-2">
                            <flux:field>
                                <flux:label>Company Logo</flux:label>
                                @if($this->internshipForm->existing_company_logo && !$this->internshipForm->company_logo)
                                    <div class="mb-2 flex items-center gap-2">
                                        <img src="{{ asset('storage/' . $this->internshipForm->existing_company_logo) }}" alt="Current Logo" class="h-12 w-12 object-contain rounded border"/>
                                        <flux:text class="text-sm text-gray-500">Current logo</flux:text>
                                    </div>
                                @endif
                                <input type="file" wire:model="internshipForm.company_logo"
                                       accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                       class="block w-full text-sm text-gray-500 dark:text-gray-400
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-md file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-blue-50 file:text-blue-700
                                              hover:file:bg-blue-100
                                              dark:file:bg-gray-700 dark:file:text-gray-200"/>
                                <flux:text class="text-xs text-gray-500 mt-1">Max 2MB. Leave empty to keep current logo.</flux:text>
                                @error('internshipForm.company_logo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                <div wire:loading wire:target="internshipForm.company_logo" class="text-sm text-blue-600 mt-1">
                                    Uploading...
                                </div>
                                @if($this->internshipForm->company_logo)
                                    <div class="mt-2 flex items-center gap-2">
                                        <img src="{{ $this->internshipForm->company_logo->temporaryUrl() }}" alt="New Logo Preview" class="h-12 w-12 object-contain rounded border"/>
                                        <flux:text class="text-sm text-green-600">New logo preview</flux:text>
                                    </div>
                                @endif
                            </flux:field>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <flux:field>
                                <flux:label>Job Description</flux:label>
                                <flux:textarea rows="3" wire:model.defer="internshipForm.job_description"/>
                                @error('internshipForm.job_description') <p
                                    class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </flux:field>
                        </div>
                        <div class="md:col-span-2">
                            <flux:field>
                                <flux:label>Requirements</flux:label>
                                <flux:textarea rows="3" wire:model.defer="internshipForm.requirements"/>
                                @error('internshipForm.requirements') <p
                                    class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </flux:field>
                        </div>
                        <div class="md:col-span-2">
                            <flux:field>
                                <flux:label>Benefits</flux:label>
                                <flux:textarea rows="2" wire:model.defer="internshipForm.benefits"/>
                                @error('internshipForm.benefits') <p
                                    class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </flux:field>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <flux:field>
                                <flux:label>Contact Name</flux:label>
                                <flux:input wire:model.defer="internshipForm.contact_name"/>
                                @error('internshipForm.contact_name') <p
                                    class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </flux:field>
                        </div>
                        <div>
                            <flux:field>
                                <flux:label>Contact Phone</flux:label>
                                <flux:input.group>
                                    <flux:input.group.prefix>+628</flux:input.group.prefix>
                                    <flux:input wire:model.defer="internshipForm.contact_phone"
                                                placeholder="xxxxxxxxxx"/>
                                </flux:input.group>
                                @error('internshipForm.contact_phone') <p
                                    class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </flux:field>
                        </div>
                        <div class="md:col-span-2">
                            <flux:field>
                                <flux:label>Contact Email</flux:label>
                                <flux:input type="email" wire:model.defer="internshipForm.contact_email"/>
                                @error('internshipForm.contact_email') <p
                                    class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </flux:field>
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-2">
                        <flux:modal.close>
                            <flux:button variant="ghost">Cancel</flux:button>
                        </flux:modal.close>
                        <flux:button type="submit" variant="primary" icon="check" wire:loading.attr="disabled"
                                     wire:target="updatePost">Save
                        </flux:button>
                    </div>
                </form>
            </div>
        </flux:modal>
        <flux:modal class="max-w-[90%] w-full sm:max-w-md outline-none" name="delete-internship-{{ $internship->id }}"
                    :dismissible="true" wire:ignore.self>
            <div class="space-y-4">
                <div>
                    <flux:heading class="text-xl">Delete Post</flux:heading>
                </div>
                <flux:separator/>
                <div class="space-y-2">
                    <p>Are you sure you want to delete this post?</p>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">This action will remove the post from your
                        listings. You can no longer edit it afterwards.</p>
                </div>
                <div class="flex items-center justify-end gap-2">
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:button color="red" variant="primary" icon="trash"
                                 wire:click="deletePost('{{ $internship->getKey() }}')"
                                 wire:loading.attr="disabled" wire:target="deletePost">
                        Delete
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    @endif
</div>
