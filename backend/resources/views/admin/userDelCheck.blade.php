<x-app-layout>
    @section('title', 'アカウント削除')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('アカウント削除') }}
        </h2>
    </x-slot>

    <div class="flex justify-center mt-12">
        <p class="py-2 px-4">
            下記のアカウントを削除しますか？</p>
    </div>

    <div class="flex justify-center mt-8">
        <form method="post" action="/admin/userList/delDone/{{$user['id']}}" class="grid grid-cols-1 gap-6">
            @csrf
            <label class="block px-16">
                <span class="text-gray-700">ID</span>
                <p class="block rounded-md border-gray-300 shadow-sm">{{$user['id']}}</p>
            </label>

            <label class="block px-16">
                <span class="text-gray-700">ユーザー名</span>
                <p class="block rounded-md border-gray-300 shadow-sm">{{$user['name']}}</p>
            </label>

            <label class="block px-16">
                <span class="text-gray-700">メールアドレス</span>
                <p class="block rounded-md border-gray-300 shadow-sm">{{$user['email']}}</p>
            </label>

            <div class="flex justify-center mt-10 mb-20">
                <a href="/admin/userList" class="h-11 w-24 mr-2 py-2 text-center bg-blue-600 text-white font-semibold hover:opacity-75 rounded
                    mr-8 md:mr-24 xl:mr-40">戻る</a>

                <button class="h-11 w-24 ml-2 py-2 text-center bg-red-600 text-white font-semibold hover:opacity-75 rounded
                    ml-8 xl:-ml-12">削除</button>
            </div>

            <input type="hidden" name="id" value="{{$user['id']}}">
            <input type="hidden" name="name" value="{{$user['name']}}">
            <input type="hidden" name="email" value="{{$user['email']}}">
        </form>
    </div>
</x-app-layout>
