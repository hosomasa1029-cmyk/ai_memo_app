<?php

use function Livewire\Volt\{state, mount, rules};
use App\Models\Memo;

state([
    'memo' => null,
    'title' => '',
    'body' => '',
]);

mount(function (Memo $memo) {
    $this->memo = $memo;
    $this->title = $memo->title;
    $this->body = $memo->body;
});

rules([
    'title' => 'required|max:50',
    'body' => 'required|max:2000',
]);

$update = function () {
    $validated = $this->validate();

    $this->memo->update([
        'title' => $validated['title'],
        'body' => $validated['body'],
    ]);

    session()->flash('status', 'メモを更新しました。');

    $this->redirect(route('memos.show', ['memo' => $this->memo]), navigate: true);
};

?>

<div>
    <div class="space-y-12">
        <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base font-semibold leading-7 text-gray-900">メモの編集</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600">メモのタイトルと本文を編集できます。</p>

            <form wire:submit="update" id="memo-form" class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-4">
                    <label for="title" class="block text-sm font-medium leading-6 text-gray-900">タイトル</label>
                    <div class="mt-2">
                        <input type="text" wire:model="title" id="title"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-full">
                    <label for="body" class="block text-sm font-medium leading-6 text-gray-900">本文</label>
                    <div class="mt-2">
                        <textarea wire:model="body" id="body" rows="3"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                    </div>
                    @error('body')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </form>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
        <a href="{{ route('memos.show', ['memo' => $memo]) }}"
            class="text-sm font-semibold leading-6 text-gray-900">キャンセル</a>
        <button type="submit" form="memo-form"
            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">更新する</button>
    </div>
</div>
