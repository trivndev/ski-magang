@php
    use Carbon\Carbon;
@endphp
<div>
    <div class="flex w-full items-center gap-3 justify-between mb-6">
        <form class="hidden md:block" wire:submit.prevent="searchPost">
            <div class="flex gap-3 items-center">
                <flux:input placeholder="Search by ID, email, or name" icon="magnifying-glass" class="max-w-xs"
                            wire:model="draftSearchQuery"/>
                <flux:button variant="primary" type="submit">Search</flux:button>
            </div>
        </form>

        <flux:modal name="filter-users" class="max-w-[90%] w-full sm:max-w-lg outline-none" :dismissible="false">
            <div class="space-y-3">
                <div>
                    <flux:heading class="text-xl">Filter Users</flux:heading>
                </div>
                <flux:separator/>
                <form class="space-y-6" wire:submit.prevent="applyFilters">
                    <div class="block md:hidden">
                        <div class="flex gap-3 items-center">
                            <flux:input wire:model="draftSearchQuery" placeholder="Search by ID, email, or name"
                                        icon="magnifying-glass"/>
                            <flux:button variant="primary">Search</flux:button>
                        </div>
                    </div>
                    <div>
                        <flux:label>
                            Sort By
                        </flux:label>
                        <flux:select placeholder="Default Newest" wire:model="draftSortBy">
                            <flux:select.option value="newest">Newest</flux:select.option>
                            <flux:select.option value="oldest">Oldest</flux:select.option>
                            <flux:select.option value="name">Name (A-Z)</flux:select.option>
                        </flux:select>
                    </div>

                    <div>
                        <flux:checkbox.group label="Select Status" wire:model="draftSelectedStatus">
                            <flux:checkbox label="Banned" value="Banned"/>
                            <flux:checkbox label="Verified" value="Verified"/>
                            <flux:checkbox label="Unverified" value="Unverified"/>
                        </flux:checkbox.group>
                    </div>

                    <div class="justify-self-end space-x-1">
                        <flux:button variant="primary" color="red" type="button" wire:click="clearFilters">Reset
                        </flux:button>
                        <flux:button variant="primary" type="submit">Apply</flux:button>
                    </div>
                </form>
            </div>
        </flux:modal>

        <div class="flex gap-3 w-fit items-center">
            <flux:modal.trigger name="filter-users" class="hidden md:flex">
                <flux:button icon="adjustments-horizontal" variant="primary">
                    Filter
                </flux:button>
            </flux:modal.trigger>
            <flux:modal.trigger name="filter-users" class="flex md:hidden">
                <flux:button icon="adjustments-horizontal" variant="primary"/>
            </flux:modal.trigger>
        </div>
    </div>
    <div class="overflow-hidden w-full overflow-x-auto rounded-radius border border-outline dark:border-outline-dark">
        <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
            <thead
                class="border-b border-outline bg-surface-alt text-sm text-on-surface-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark-strong">
            <tr>
                <th scope="col" class="p-4">#</th>
                <th scope="col" class="p-4">User ID</th>
                <th scope="col" class="p-4">User</th>
                <th scope="col" class="p-4">Role</th>
                <th scope="col" class="p-4">Register At</th>
                <th scope="col" class="p-4">Status</th>
                <th scope="col" class="p-4">Action</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-outline dark:divide-outline-dark">
            @forelse ($users as $user)
                <tr>
                    <td class="p-4">{{ $loop->iteration }}</td>
                    <td class="p-4">{{ $user->id }}</td>
                    <td class="p-4">
                        <div class="flex w-max items-center gap-2">
                            <flux:profile :chevron="false" avatar:name="{{ ucfirst(strtolower($user->name)) }}"
                                          avatar:color="auto"/>
                            <div class="flex flex-col">
                                <span class="text-neutral-900 dark:text-white">{{ $user->name }}</span>
                                <span
                                    class="text-sm text-neutral-600 opacity-85 dark:text-neutral-300">{{ $user->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">
                        @if(auth()->user()->can('manage role'))
                            <flux:select wire:model="selectedRoles.{{ $user->id }}"
                                         wire:change="setUserRole('{{ $user->id }}', $event.target.value)"
                                         placeholder="Select role" class="min-w-[8rem]">
                                @foreach(($roles ?? collect()) as $role)
                                    <flux:select.option
                                        value="{{ $role->name }}">{{ ucfirst($role->name) }}</flux:select.option>
                                @endforeach
                            </flux:select>
                        @else
                            {{  ucfirst($user->getRoleNames()->first()) ?? '-' }}
                        @endif
                    </td>
                    <td class="p-4">{{ Carbon::parse($user->created_at)->format("D, d M Y") }}</td>
                    <td class="p-4">
                        @if($user->banned_at)
                            <span
                                class="inline-flex overflow-hidden rounded-radius border-zinc-600 px-1 py-0.5 text-xs font-medium text-white bg-zinc-700">Banned</span>
                        @elseif($user->email_verified_at)
                            <span
                                class="inline-flex overflow-hidden rounded-radius border-success px-1 py-0.5 text-xs font-medium text-success bg-success/10">Verified</span>
                        @else
                            <span
                                class="inline-flex overflow-hidden rounded-radius border-danger px-1 py-0.5 text-xs font-medium text-danger bg-danger/10">Unverified</span>
                        @endif
                    </td>
                    <td class="p-4">
                        <flux:dropdown position="left">
                            <flux:button variant="ghost" icon="ellipsis-vertical"/>

                            <flux:menu>
                                @php
                                    $viewer = auth()->user();
                                @endphp
                                @if(!$user->email_verified_at)
                                    <flux:menu.item wire:click="verifyUser('{{ $user->id }}')">
                                        Verify User
                                    </flux:menu.item>
                                @else
                                    @php
                                        $canManageUser = $viewer?->can('manage user');
                                        $viewerIsSupervisor = $viewer?->hasRole('supervisor');
                                        $targetIsSupervisor = $user->hasRole('supervisor');
                                        $canActOnTarget = $canManageUser && ($viewerIsSupervisor || !$targetIsSupervisor);
                                    @endphp
                                    @if($canManageUser)
                                        <flux:menu.item wire:click="unverifyUser('{{ $user->id }}')">
                                            Unverify User
                                        </flux:menu.item>
                                    @endif
                                    @if($user->banned_at)
                                        @if($canActOnTarget)
                                            <flux:menu.item wire:click="unbanUser('{{ $user->id }}')">
                                                Unban User
                                            </flux:menu.item>
                                        @else
                                            <flux:menu.item disabled>No Option Available</flux:menu.item>
                                        @endif
                                    @else
                                        @if($canActOnTarget)
                                            <flux:menu.item wire:click="banUser('{{ $user->id }}')">
                                                Ban User
                                            </flux:menu.item>
                                        @else
                                            <flux:menu.item disabled>No Option Available</flux:menu.item>
                                        @endif
                                    @endif
                                @endif
                            </flux:menu>
                        </flux:dropdown>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="py-4 text-center text-sm text-neutral-600 dark:text-neutral-300" colspan="7">No data
                        found
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif
</div>
