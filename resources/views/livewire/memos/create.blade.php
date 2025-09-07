<?php

use function Livewire\Volt\{state, rules};
use App\Models\Memo;

state([
    'title' => '',
    'body' => '',
]);

rules([
    'title' => ['required', 'string', 'max:50'],
    'body' => ['required', 'string', 'max:2000'],
]);

$save = function () {
    $validated = $this->validate();

    $memo = new Memo();
    $memo->user_id = auth()->id();
    $memo->title = $validated['title'];
    $memo->body = $validated['body'];
    $memo->save();

    $this->redirect(route('memos.show', $memo), navigate: true);
};

?>

<div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
    <form wire:submit="save" class="space-y-6">
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">
                タイトル
            </label>
            <div class="mt-1">
                <input type="text" wire:model="title" id="title"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="メモのタイトルを入力してください">
                @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="body" class="block text-sm font-medium text-gray-700">
                本文
            </label>
            <div class="mt-1">
                <textarea wire:model="body" id="body" rows="10"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="メモの本文を入力してください"></textarea>
                @error('body')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="/memos"
                class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                キャンセル
            </a>
            <button type="submit"
                class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                保存
            </button>
        </div>
    </form>
</div>
