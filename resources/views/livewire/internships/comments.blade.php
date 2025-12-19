<div class="space-y-4" wire:poll.5s>
    <flux:heading size="lg">Comments ({{ $comments->count() }})</flux:heading>

    @auth
        <form wire:submit="addComment" class="space-y-2">
            <flux:textarea
                wire:model="newComment"
                placeholder="Write a comment..."
                rows="2"
            />
            @error('newComment') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            <div class="flex justify-end">
                <flux:button type="submit" variant="primary" size="sm" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="addComment">Post Comment</span>
                    <span wire:loading wire:target="addComment">Posting...</span>
                </flux:button>
            </div>
        </form>
    @else
        <flux:text class="text-gray-500">Please <a href="{{ route('login') }}" class="text-blue-600 hover:underline">login</a> to leave a comment.</flux:text>
    @endauth

    <div class="space-y-3 max-h-64 overflow-y-auto">
        @forelse($comments as $comment)
            <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg" wire:key="comment-{{ $comment->id }}">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-medium">
                            {{ $comment->user->initials() }}
                        </div>
                        <div>
                            <flux:text class="font-medium text-sm">{{ $comment->user->name }}</flux:text>
                            <flux:text class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</flux:text>
                        </div>
                    </div>
                    @if(auth()->id() === $comment->user_id)
                        <flux:button
                            variant="ghost"
                            size="xs"
                            icon="trash"
                            wire:click="deleteComment({{ $comment->id }})"
                            wire:confirm="Are you sure you want to delete this comment?"
                            class="text-red-500 hover:text-red-700"
                        />
                    @endif
                </div>
                <flux:text class="mt-2 text-sm">{{ $comment->content }}</flux:text>
            </div>
        @empty
            <flux:text class="text-gray-500 text-center py-4">No comments yet. Be the first to comment!</flux:text>
        @endforelse
    </div>
</div>
