<flux:modal name="create-post" class="max-w-[90%] w-full sm:max-w-xl outline-none max-h-128" :dismissible="false">
    <div class="space-y-5">
        <div>
            <div>
                <flux:heading class="text-xl">Add New Post</flux:heading>
            </div>
            <flux:separator/>
        </div>
        <form class="space-y-6" wire:submit.prevent="createPost" wire:ignore.self>
            <flux:fieldset class="space-y-6">
                <flux:field>
                    <flux:input
                        label="Job Title" badge="required"
                        placeholder="Enter job title"
                        wire:model.live.debounce.500ms="internshipForm.job_title"
                        value="{{ old('job_title') }}"
                    />
                </flux:field>

                <flux:field>
                    <flux:input badge="required"
                                label="Company"
                                placeholder="Company name"
                                wire:model.live.debounce.500ms="internshipForm.company"
                                value="{{ old('company') }}"
                    />
                </flux:field>

                <flux:field>
                    <flux:input
                        label="Location" badge="required"
                        placeholder="Job location"
                        wire:model.live.debounce.500ms="internshipForm.location"
                        value="{{ old('location') }}"
                    />
                </flux:field>

                <flux:field>
                    <flux:textarea
                        label="Job Description" badge="required"
                        placeholder="Describe the job in detail"
                        wire:model.live.debounce.500ms="internshipForm.job_description"
                    >{{ old('job_description') }}</flux:textarea>
                </flux:field>

                <flux:field>
                    <flux:textarea
                        label="Requirements"
                        badge="required"
                        placeholder="List the qualifications or requirements"
                        wire:model.live.debounce.500ms="internshipForm.requirements"
                    >{{ old('requirements') }}</flux:textarea>
                </flux:field>

                <flux:field>
                    <flux:textarea
                        label="Benefits"
                        badge="optional"
                        placeholder="Describe the benefits (optional)"
                        wire:model.live.debounce.500ms="internshipForm.benefits"
                    >{{ old('benefits') }}</flux:textarea>
                </flux:field>

                <flux:field>
                    <flux:input
                        label="Contact Email" badge="optional"
                        placeholder="email@example.com"
                        wire:model.live.debounce.500ms="internshipForm.contact_email"
                        value="{{ old('contact_email') }}"
                    />
                </flux:field>

                <flux:field>
                    <flux:label>Contact Phone</flux:label>
                    <flux:input.group>
                        <flux:input.group.prefix>+628</flux:input.group.prefix>
                        <flux:input
                            badge="required"
                            placeholder="xxxxxxxxxx"
                            wire:model.live.debounce.500ms="internshipForm.contact_phone"
                            value="{{ old('contact_phone') }}"
                        />
                    </flux:input.group>
                </flux:field>

                <flux:field>
                    <flux:input
                        label="Contact Name" badge="required"
                        placeholder="Contact person name"
                        wire:model.live.debounce.500ms="internshipForm.contact_name"
                        value="{{ old('contact_name') }}"
                    />
                </flux:field>

                <flux:field>
                    <flux:input badge="required"
                                label="End Date"
                                type="date"
                                wire:model.live.debounce.500ms="internshipForm.end_date"
                                value="{{ old('end_date') }}"
                    />
                </flux:field>

                <flux:field>
                    <flux:select badge="required"
                                 label="Vocational Major"
                                 placeholder="Select major"
                                 wire:model.live.debounce.500ms="internshipForm.vocational_major_id"
                    >
                        <option>Select a major</option>
                        @foreach ($vocationalMajors as $vocationalMajor)
                            <option
                                value="{{ $vocationalMajor->id }}" {{ old('vocational_major_id') == $vocationalMajor->id ? 'selected' : '' }}>
                                {{ $vocationalMajor->major_name}}
                            </option>
                        @endforeach
                    </flux:select>
                </flux:field>
            </flux:fieldset>

            <div class="flex gap-3 justify-end">
                <flux:modal.close name="create-post">
                    <flux:button variant="primary" color="red">
                        Cancel
                    </flux:button>
                </flux:modal.close>
                <flux:button variant="primary" type="submit">
                    Create Post
                </flux:button>
            </div>
        </form>
    </div>
</flux:modal>
